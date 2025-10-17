<?php

namespace BookneticApp\Providers\FSCode\Services;

use BookneticApp\Providers\Core\Bootstrap;
use BookneticApp\Providers\FSCode\Clients\FSCodeAPIClient;
use BookneticApp\Providers\FSCode\Clients\RequestDTOs\ActivateRequestDTO;
use BookneticApp\Providers\Helpers\Helper;
use BookneticApp\Providers\IoC\Container;

class FSCodeApiService
{
    private FSCodeAPIClient $client;

    public function __construct(FSCodeApiClient $client)
    {
        $this->client = $client;
    }

    public function activate(ActivateRequestDTO $dto)
    {
        $product = Helper::isSaaSVersion() ? 'booknetic-saas' : 'booknetic';
        $result = $this->client->request($product.'/product/activate', 'POST', $dto->toArray());
        if (! ($result['status'] ?? false) || ! isset($result['data']['license_code'])) {
            if (($result['error']['code'] ?? '') === 'license_is_not_free' && isset($result['data']['activated_website'])) {
                throw new \RuntimeException(bkntc__('The license code is used for this website: %s', [$result['data']['activated_website']]));
            }

            throw new \RuntimeException($result['error']['message'] ?? bkntc__('Your server can not access our license server via CURL! Our license server is "https://api.fs-code.com". Please contact your hosting provider and ask them to solve the problem.'));
        }

        return $result['data'];
    }

    public function checkUpdatesAndSync(array $addons): array
    {
        $product = Helper::isSaaSVersion() ? 'booknetic-saas' : 'booknetic';
        $response = $this->client->request($product.'/addons/check_update', 'POST', [
            'addons' => $addons,
        ]);

        $responseData = $response['data'] ?? [];

        if (isset($responseData['unowned_addons']) && is_array($responseData['unowned_addons'])) {
            $this->handleUnownedAddonUsage($responseData['unowned_addons']);
        }

        return $responseData;
    }

    private function handleUnownedAddonUsage(array $addons): void
    {
        $normalizedAddons = [];

        foreach ($addons as $addon) {
            if (! is_array($addon) || empty($addon['slug'])) {
                continue;
            }

            $normalizedAddons[ $addon['slug'] ] = $addon;
        }

        Helper::setOption('synced_addons', $normalizedAddons, false);
    }

    public function sync(array $addons = []): void
    {
        foreach (Bootstrap::getAddons() as $addon) {
            $addons[$addon::getAddonSlug()] = $addon::getVersion();
        }

        $this->checkUpdatesAndSync($addons);
    }

    public function reDeclareApiClient(): void
    {
        $this->client = Container::get(FSCodeAPIClient::class);
    }
}
