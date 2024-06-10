@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="col-13 grid-margin stretch-card">
        <div class="card">
            <div id="mapid" style="height: 400px;"></div>
            <div class="info-wrapper">
                <div class="info-header">
                    <span class="info-icon"><i class="ti-truck"></i></span>
                    <span class="info-text">Your package is on the way.</span>
                </div>
                <div class="info-content">
                    <div class="profile">
                        <img src="https://via.placeholder.com/50" alt="Driver's profile picture" class="profile-pic">
                        <div class="profile-details">
                            <span class="profile-name">Jhonson Rewndos</span>
                            <span class="profile-rating">4.7 (256)</span>
                        </div>
                    </div>
                    <div class="delivery-details">
                        <span class="estimated-time">Estimated time: 23 min</span>
                        <span class="service-type">Service: Express</span>
                    </div>
                </div>
                <div class="package-photo">
                    <img src="https://via.placeholder.com/150" alt="Package photo" class="package-pic">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
