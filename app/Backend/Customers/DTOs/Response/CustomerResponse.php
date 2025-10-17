<?php

namespace BookneticApp\Backend\Customers\DTOs\Response;

class CustomerResponse
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;
    private string $email;
    private ?string $birthdate;
    private ?string $notes;
    private ?string $gender = null;
    private int $userId = 0;
    private ?string $profileImage = null;

    /**
     * @return CustomerResponse
     */
    public static function createEmpty(): CustomerResponse
    {
        $instance = new self();

        $instance->setId(0);
        $instance->setFirstName('');
        $instance->setLastName('');
        $instance->setPhoneNumber('');
        $instance->setEmail('');
        $instance->setBirthdate('');
        $instance->setNotes(null);
        $instance->setGender(null);
        $instance->setUserId(0);
        $instance->setProfileImage('');

        return $instance;
    }

    /**
     * @param int $id
     * @return CustomerResponse
     */
    public function setId(int $id): CustomerResponse
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $firstName
     * @return CustomerResponse
     */
    public function setFirstName(string $firstName): CustomerResponse
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName): CustomerResponse
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $phoneNumber
     * @return CustomerResponse
     */
    public function setPhoneNumber(string $phoneNumber): CustomerResponse
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $email
     * @return CustomerResponse
     */
    public function setEmail(string $email): CustomerResponse
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $birthdate
     * @return CustomerResponse
     */
    public function setBirthdate(?string $birthdate): CustomerResponse
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    /**
     * @param string|null $notes
     * @return CustomerResponse
     */
    public function setNotes(?string $notes): CustomerResponse
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param ?string $gender
     * @return CustomerResponse
     */
    public function setGender(?string $gender): CustomerResponse
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param ?string $profileImage
     * @return CustomerResponse
     */
    public function setProfileImage(?string $profileImage): CustomerResponse
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    /**
     * @param int $userId
     * @return CustomerResponse
     */
    public function setUserId(int $userId): CustomerResponse
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
