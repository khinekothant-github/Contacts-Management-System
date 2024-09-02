@section('title', 'Edit Contact Detail Page')

@extends('layouts.app')

@extends('layouts.Edit_Archive_Modal')
@extends('layouts.Add_Archive_Activity_Modal')
@extends('layouts.Edit_Archive_Activity_Modal')
@section('content')
@if (Auth::check() && Auth::user()->role == 'Sales_Agent')
    @if (session('success'))
        <!-- Trigger the modal with a button (hidden, will be triggered by JavaScript) -->
        <button id="successModalBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#successModal"
            style="display: none;">
            Open Modal
        </button>
        <!-- Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header"
                        style="background: linear-gradient(180deg, rgb(255, 180, 206) 0%, hsla(0, 0%, 100%, 1) 100%);
                border:none;">
                        <h5 class="modal-title font-educ" id="successModalLabel">Success</h5>
                    </div>
                    <div class="modal-body" style="color: #91264c">
                        {{ session('success') }}
                    </div>
                    <div class="modal-footer" style="border:none">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Script to trigger the modal -->
        <script type="text/javascript">
            window.onload = function() {
                document.getElementById('successModalBtn').click();
            };
        </script>
    @endif
    {{-- css will edit to css file soon --}}
    <link rel="stylesheet" href="{{ URL::asset('css/contact_detail.css') }}">
    <div class="row border-educ rounded">
        <div class="col-md-5 border-right" id="contact-detail">
            <div class="table-title d-flex justify-content-between align-items-center my-3">
                <h2 class="mt-2 ml-3 headings">Contact Detail</h2>
                @if (Auth::check() && Auth::user()->role == 'Sales_Agent')
                    <a href="{{ route('archive#edit', $editArchive->contact_archive_pid) }}" class="btn hover-action mx-1"
                        data-toggle="modal" data-target="#editArchiveModal">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                @endif
            </div>
            <div class="row row-margin-bottom row-border-bottom mx-1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-educ" for="name">Name</label>
                        <h5 class=" fonts" id="name">{{ $editArchive->name }}</h5>
                    </div>
                    <div class="form-group">
                        <label class="font-educ" for="contact-number">Contact Number</label>
                        <h5 class=" fonts" id="contact_number">{{ $editArchive->contact_number }}</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-educ" for="email">Email</label>
                        <h5 class=" fonts" id="email">{{ $editArchive->email }}</h5>
                    </div>
                    <div class="form-group">
                        <label class="font-educ" for="country">Country</label>
                        <h5 class=" fonts" id="country">{{ $editArchive->country }}</h5>
                    </div>
                </div>
            </div>
            <div class="row row-margin-bottom row-border-bottom mx-1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-educ" for="address">Address</label>
                        <h5 class=" fonts" id="address" style="height: 125px;">{{ $editArchive->address }}</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-educ" for="date-of-allocation">Date of Allocation</label>
                        <h5 class=" fonts" id="date-of-allocation">{{ $editArchive->date_of_allocation }}</h5>
                    </div>
                    <div class="form-group">
                        <label class="font-educ" for="qualification">Qualification</label>
                        <h5 class=" fonts" id="qualification">{{ $editArchive->qualification }}</h5>
                    </div>
                </div>
            </div>
            <div class="row mx-1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-educ" for="skills">Skills</label>
                        <h5 class=" fonts" id="skills">{{ $editArchive->skills }}</h5>
                    </div>
                    <div class="form-group">
                        <label class="font-educ" for="source">Source</label>
                        <h5 class=" fonts" id="source">{{ $editArchive->source }}</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-educ" for="job-role">Job Role</label>
                        <h5 class=" fonts" id="job-role">{{ $editArchive->job_role }}</h5>
                    </div>
                    <div class="form-group">
                        <label class="font-educ" for="status">Status</label>
                        <h5 class="fonts p-1 rounded" id="status">
                            {{ trim(
                                $editArchive->status === 'HubSpot Contact'
                                    ? 'HubSpot'
                                    : ($editArchive->status === 'Discard'
                                        ? 'Discard'
                                        : ($editArchive->status === 'InProgress'
                                            ? 'In Progress'
                                            : ($editArchive->status === 'New'
                                                ? 'New'
                                                : ($editArchive->status === 'Archive'
                                                    ? 'Archive'
                                                    : '')))),
                            ) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 px-3" id="activity-container">
            <div class="d-flex justify-content-between align-items-center my-3">
                <h2 class="mt-2 ml-2 headings">Activities Notifications</h2>
            </div>
            <!-- Filter Buttons -->
            <div class="btn-group mb-3" role="group" aria-label="Activity Filter Buttons">
                <button type="button" class="btn activity-button mx-2 active-activity-button"
                    data-filter="all">Activities</button>
                <button type="button" class="btn activity-button mx-2" data-filter="meeting">Meetings</button>
                <button type="button" class="btn activity-button mx-2" data-filter="email">Emails</button>
                <button type="button" class="btn activity-button mx-2" data-filter="phone">Calls</button>
                <button type="button" class="btn activity-button mx-2" data-filter="whatsapp">Whatsapp</button>
            </div>
            {{-- Iterating all the activities from all contacts --}}
            <div class="activities">
                @forelse ($engagementArchive->groupBy(function ($date) {
                                                                                                                return \Carbon\Carbon::parse($date->date)->format('F Y'); // Group by month and year
                                                                                                            }) as $month => $activitiesInMonth)
                    <div class="activity-list">
                        <div class="activity-date my-3 ml-3">
                            <span class="text-muted">{{ $month }}</span>
                        </div>
                        @foreach ($activitiesInMonth as $activity)
                            <div class="activity-item mb-3 mx-3 border-educ rounded p-3"
                                data-type="{{ strtolower($activity->activity_name) }}">
                                <h5 class="font-educ">{{ $activity->activity_name }} Activities</h5>
                                <small>{{ \Carbon\Carbon::parse($activity->date)->format('d-m-Y') }}</small>
                                <p class="text-muted">{{ $activity->details }}</p>
                                {{-- @if ($activity->attachments)
                                    <p class="text-muted">Attachment: <a href="{{ Storage::url($activity->attachments) }}"
                                            target="_blank">View File</a></p>
                                @endif --}}
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="no-activities text-center my-4">
                        <p class="text-muted">No Activities Found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Activity Taken Section -->
    <div class="table-title d-flex justify-content-between align-items-center mt-5">
        <div class="d-flex align-items-center">
            <h2 class="ml-2 mb-1 headings">Activity Taken</h2>
        </div>
        <div class="d-flex align-items-center mr-2 mb-2">
            @if (Auth::check() && Auth::user()->role == 'Sales_Agent')
                <button class="btn hover-action add-activity-button" data-toggle="modal"
                    data-target="#addArchiveActivityModal">
                    <i style="font-size: 22px;" class="fa-solid fa-square-plus p-1"></i>
                </button>
            @endif
        </div>
    </div>
    <!-- Table -->
    <table class="table table-hover mt-2">
        <thead class="font-educ text-left">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                <th scope="col">Description</th>
                <th scope="col">Attachment</th>
                @if (Auth::check() && Auth::user()->role == 'Sales_Agent')
                    <th scope="col">Action</th>
                @endif
            </tr>
        </thead>
        <tbody class="text-left bg-row">
            <?php $i = 0; ?>

            @foreach ($engagementArchive as $engagement)
                @php
                    // Decode the JSON or handle the attachments array properly
                    $attachments = json_decode($engagement->attachments, true); // Assuming it's a JSON string
$filename = $attachments[0] ?? ''; // Get the first filename from the array
$filePath = public_path('attachments/leads/' . $filename);
                @endphp
                <tr>
                    <td> {{ ++$i }} </td>
                    <td> {{ $engagement->date }} </td>
                    <td> {{ $engagement->activity_name }} </td>
                    <td> {{ $engagement->details }} </td>
                    <td>
                        @if (file_exists($filePath) && $filename)
                            <img src="{{ asset('attachments/leads/' . $filename) }}" alt="Attachment Image"
                                style="width: 100px; height: auto;">
                        @else
                            No Image Available
                        @endif
                    </td>
                    @if (Auth::check() && Auth::user()->role == 'Sales_Agent')
                        <td>
                            <a class="btn hover-action" data-toggle="modal"
                                {{ Auth::user()->role == 'Sales-Agent' ? 'data-target="#updateArchiveActivityModal- $engagement->engagement_archive_pid "' : '' }}>
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="alert alert-danger text-center mt-5">
            <strong>Access Denied!</strong> You do not have permission to view this page.
        </div>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ URL::asset('js/contact_detail.js') }}"></script>
    <script src="{{ URL::asset('js/status_color.js') }}"></script>
@endsection
