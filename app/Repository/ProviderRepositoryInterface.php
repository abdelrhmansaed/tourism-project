<?php

namespace App\Repository;

use App\Http\Requests\AgentRequest;
use App\Models\Agent;
use App\Models\Provider;
use Illuminate\Http\Request;
interface ProviderRepositoryInterface
{
    public function index();
    public function create();
    public function store(Request  $request );
    public function edit($id);
    public function update(array $data, Provider $provider);
    public function destroy($request);
    public function tripRequests();
    public function approveRequestWaitingPayment($request_id);
    public function approveRequest($request_id);
    public function rejectRequest($request_id);
    public function TripsWatingConfirm();
    public function confirmedTrips();
    public function rejectedTrips();
    public function showProfile($id);






}
