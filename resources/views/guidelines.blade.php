@extends('layouts.app')

@section('title', 'University Guidelines')

@section('content')

<section class="guidelines-content" id="guidelines">
    <div class="guidelines-content-container">
        <h2 class="guidelines-header">University Guidelines</h2>
        <div class="guidelines-content">
            <h3>Code of Conduct</h3>
            <p>All students, faculty, and staff are expected to uphold the highest standards of behavior, in line with the University’s core values of integrity, respect, and responsibility.</p>
            
            {{-- <h3>Health and Safety Protocols</h3>
            <p>To ensure the safety of all individuals on campus, we ask that everyone follows the prescribed health and safety guidelines, which include wearing face masks, regular hand sanitation, and maintaining appropriate social distancing in accordance with health authorities' recommendations.</p>

            <h3>Campus Rules</h3>
            <p>The use of university facilities must be scheduled in advance and approved by the appropriate department. All users must ensure that facilities are left in good condition after use. Any damages or incidents must be reported to the General Services Office immediately.</p>

            <h3>Academic Integrity</h3>
            <p>Cheating, plagiarism, and other forms of academic dishonesty are strictly prohibited. Students found violating these rules will be subject to disciplinary action, which may include suspension or expulsion.</p>

            <h3>Visitor Guidelines</h3>
            <p>Visitors to the campus must check in at the front gate security office, where they will be issued visitor passes. These passes must be worn at all times while on campus.</p> --}}

            <h3>Reporting Issues</h3>
            <p>If you witness or experience any issues or violations of university policies, please report them to the Security Office or the appropriate university authority.</p>
        </div>
    </div>
</section>

<!--=======STYLESHEET=======-->
<link rel="stylesheet" href="{{asset('css/guidelines.css')}}">

@endsection
