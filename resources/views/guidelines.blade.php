@extends('layouts.app')

@section('title', 'University Guidelines')

@section('content')

<section class="guidelines-content" id="guidelines">
    <div class="guidelines-content-container">
        <h2 class="guidelines-header">Vehicle Registration Guidelines</h2>
        <div class="guidelines-content">
            <h3>Lists of Requirements for Application of Vehicle Registration</h3>
            <p>In preparation for its implementation, we would like to emphasize the registration of vehicles and the required documents for the issuance of stickers as stated in Section II of the rules mentioned above and regulations:</p>
            <br>
            <p>1. Officials, faculty and staff, students, parents, and stakeholders who frequently and usually drive/using a vehicle to campus shall register their vehicle at the General Services Office every year requires the following documents:</p>
            <h3>Accomplished Application for Vehicle Registration Form </h3>
            <ul>
                <p>•	Certificate of Registration of the vehicle </p>
                <p>•	Official Receipt of Registration  </p>
                <p>•	Driver’s License</p>
            </ul>
            <p>
                <b>Requirements for E-bikes</b>
            </p>

            <p>•	Certificate of Ownership  </p>
            <p>•	Driver’s License    </p>

            <p>An additional requirement for parents and students is a photocopy of the certificate of enrollment. </p>
            <p>2. After filling out the registration form, wait for the approval email sent by the (GSO) General Service Office before going to the General Service Office to claim your RFID sticker and RFID card. If approved, a registration fee of P100.00 will be paid to the Cashier’s Office. </p>
            <p>3. Vehicle stickers shall be issued upon registration and shall be valid for one year and renewable thereafter, subject to payment of the renewal fee and other regulations. The type of registration/user is distinguished by color as follows: </p>
            
                <p>University Officials (Senior and Junior) </p>
                <p>Neon RED Faculty and Employees </p>
                <p>Neon BLUE Students </p>
                <p>Neon GREEN Tenants </p>
                <p>Neon ORANGE Officials </p>
                <p>Neon YELLOW Parents </p>
            
        </div>
    </div>
</section>

<!--=======STYLESHEET=======-->
<link rel="stylesheet" href="{{asset('css/guidelines.css')}}">

@endsection
