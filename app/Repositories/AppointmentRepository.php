<?php

namespace App\Repositories;

use App\Models\Appointment;

class AppointmentRepository {

    /**
     * Make Appointment
     * 
     * @author Muhammad Waqar
     */
    public function save($data){
        $data = $this->calculateFee($data);
        return Appointment::create($data);
    }

    public function calculateFee($data){
        $doctor_fee = (float) $data['doctor_fee_amount'];
        $data['admin_fee_amount'] = $doctor_fee * (20/100);
        $data['doctor_fee_amount'] = $doctor_fee - $data['admin_fee_amount'];

        return $data;
    }

    public function getAppointmentsByDoctor($params){
        return Appointment::select(['id', 'booking_time', 'doctor_fee_amount'])->clientName()->where('doctor_id', $params['doctor_id'])->paginate(10);
    }

    public function getAdminEarnings(){
        // return Appointment::select('admin_fee_amount')->get();
        // return Appointment::sum('admin_fee_amount');
        return Appointment::select(['id', 'admin_fee_amount', 'created_at'])->clientName()->paginate(10);

    }


}