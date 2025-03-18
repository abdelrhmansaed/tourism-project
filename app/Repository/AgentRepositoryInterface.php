<?php

namespace App\Repository;

use App\Http\Requests\AgentRequest;
use App\Models\Agent;
use Illuminate\Http\Request;

interface AgentRepositoryInterface
{
    public function index();
    public function create();
    public function store( AgentRequest$request);
    public function edit($id);
    public function update(array $data, Agent $agent);
    public function destroy($request);
    public function storeTripRequest(Request $request);
    public function myRequests();
    public function confirmedTrips();
    public function rejectedTrips();
    public function requestTrip($trip_id);
    public function dashboard();
    public function showProfile($id);







}
