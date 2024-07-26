<div class="title-section d-flex align-items-center mb-3 justify-content-end">
    @php
        $formattedDate = $contact->created_at->format('dS M Y g:i A');
    @endphp
    <span class=" badge bg-primary ms-3 "><i class='bx bx-time-five'></i>&nbsp;{{ $formattedDate }}</span>
</div>
<div class="row border-top border-bottom py-3">
    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">name</b>
            <span>{{ $contact->name }}</span>
        </div>
    </div>

    <div class="col-xl-4 col-md-4">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Email</b>
            <span>{{ $contact->email }}</span>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">phone</b>

            <span class="badge bg-primary"> {{ $contact->phone }}</span>
        </div>
    </div>
</div>

<div class="row border-bottom py-3">

    <div class="col-xl-3 col-md-3">
        <div class="card-content">
            <b class="d-block text-uppercase text-14">Message</b>
            <span>{!! $contact->message !!}</span>
        </div>
    </div>

</div>
