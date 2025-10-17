<?php

namespace BookneticApp\Backend\Payments\Controllers;

use BookneticApp\Backend\Payments\DTOs\SavePaymentRequest;
use BookneticApp\Backend\Payments\Exceptions\PaymentException;
use BookneticApp\Backend\Payments\Services\PaymentService;
use BookneticApp\Providers\Core\Capabilities;
use BookneticApp\Providers\Core\Controller;
use BookneticApp\Providers\Request\Post;
use Exception;

class PaymentAjaxController extends Controller
{
    private PaymentService $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function info()
    {
        try {
            Capabilities::must('payments');

            $appointmentId = Post::int('id');
            $info = $this->service->getAppointmentInfo($appointmentId);

            return $this->modalView('info', ['info' => $info]);
        } catch (PaymentException $e) {
            return $this->response(false, $e->getMessage());
        } catch (Exception $e) {
            return $this->response(false, bkntc__('An unexpected error occurred while retrieving payment information.'));
        }
    }

    public function edit_payment()
    {
        try {
            Capabilities::must('payments_edit');
            $appointmentId = Post::int('payment');
            $mn2 = Post::int('mn2');
            $info = $this->service->getAppointmentInfo($appointmentId);

            return $this->modalView('edit_payment', ['payment' => $info, 'mn2' => $mn2]);
        } catch (PaymentException $e) {
            return $this->response(false, $e->getMessage());
        } catch (Exception $e) {
            return $this->response(false, bkntc__('An unexpected error occurred while preparing payment edit form.'));
        }
    }

    public function save_payment()
    {
        try {
            Capabilities::must('payments_edit');

            $appointmentId = Post::int('id');
            $pricesInput = Post::json('prices');
            $paidAmount = Post::float('paid_amount');
            $status = Post::string('status', '', ['pending', 'paid', 'canceled', 'not_paid']);

            $savePaymentRequest = new SavePaymentRequest();
            $savePaymentRequest->setAppointmentId($appointmentId)
                ->setPrices($pricesInput)
                ->setPaidAmount($paidAmount)
                ->setStatus($status);

            $this->service->savePayment($savePaymentRequest);

            return $this->response(true, ['message' => bkntc__('Payment saved successfully!')]);
        } catch (PaymentException $e) {
            return $this->response(false, $e->getMessage());
        } catch (Exception $e) {
            return $this->response(false, bkntc__('An unexpected error occurred while saving the payment.'));
        }
    }

    public function complete_payment()
    {
        try {
            Capabilities::must('payments_edit');
            $appointmentId = Post::int('id');

            $this->service->completePayment($appointmentId);

            return $this->response(true, ['message' => bkntc__('Payment completed successfully!')]);
        } catch (PaymentException $e) {
            return $this->response(false, $e->getMessage());
        } catch (Exception $e) {
            return $this->response(false, bkntc__('An unexpected error occurred while completing the payment.'));
        }
    }
}
