<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body>
    <div class="all">
        <div x-data="searchAvailability" id="searchAvailability" class="searchAvailability">
            <button id="dates" x-on:click="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                    class="bi bi-calendar-event" viewBox="0 0 16 16">
                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                </svg>
                STAY DATES
            </button>
            <form action="" x-show="!isOpen" x-on:submit="search" id="form">
                <div class="form_elm">
                    <input x-model="checkIn" x-ref="checkIn" type="date" placeholder="Select check in Dates"
                        id="checkin">
                    <span style="display:none"></span>
                </div>
                <div class="form_elm">
                    <input x-model="checkOut" x-ref="checkOut" type="date" placeholder="Select check out Dates"
                        id="checkin">
                    <span style="display:none;"></span>
                </div>
                <button id="Available">Search Availability</button>
            </form>
        </div>


        <div class="searchRooms" x-data="searchRooms" id="searchRooms">
            <button id="room" x-on:click="toggle">
                Search Rooms
            </button>
            <div x-show="isOpen">
                <form class="rooms" x-on:submit="formSubmit" >
                    <table id="first">
                        <thead>
                            <th>Room Category</th>
                            <th>Available Rooms</th>
                        </thead>
                        <tbody>

                            <template x-for="rc in roomCategory">
                                <tr>
                                    <td x-text="rc['name']"></td>
                                    <td>
                                        <select :id="rc['id']" class="rooms" :name="rc['id']" required
                                            x-on:change="selectNoOfRooms">
                                            <option value="0" selected>Not Select</option>

                                            <template
                                                x-for="i in (new Array(rc['availableRooms'])).fill('').map((e,i)=>i+1)">
                                                <option x-text="i + ' Room'" x-bind:value="i"></option>
                                            </template>
                                        </select>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>



                    <table id="first">
                        <thead>
                            <th>Room Category</th>
                            <th>Adults</th>
                            <th>Children(5-12yr)</th>
                            <th>Infant(Upto 4yr)</th>
                            <th>Meal Plan</th>
                            <th>Cost</th>
                            <th>GST</th>
                            <th>Total</th>
                        </thead>
                        <tbody>

                            <template x-for="booking in bookings">
                                <tr>
                                    <td x-text="booking['name']"></td>
                                    <td>
                                        <select x-on:change="changeValue" :data-id="booking['id']" class="rooms"
                                            name="adults" required>
                                            <option value="0" selected>0</option>
                                            <template
                                                x-for="i in (new Array(booking['maxAdults'])).fill('').map((e,i)=>i+1)">
                                                <option x-text="i" x-bind:value="i"></option>
                                            </template>
                                        </select>
                                    </td>
                                    <td><select x-on:change="changeValue" :data-id="booking['id']" class="rooms"
                                            name="childs" required>
                                            <option value="0" selected>0</option>
                                            <template
                                                x-for="i in (new Array(booking['maxChildren'])).fill('').map((e,i)=>i+1)">
                                                <option x-text="i" x-bind:value="i"></option>
                                            </template>
                                        </select></td>
                                    <td><select x-on:change="changeValue" :data-id="booking['id']" class="rooms"
                                            name="infants" x-on:change="changeValue" :data-id="booking['id']" required>
                                            <option value="0" selected>0</option>
                                            <template
                                                x-for="i in (new Array(booking['maxInfants'])).fill('').map((e,i)=>i+1)">
                                                <option x-text="i" x-bind:value="i"></option>
                                            </template>
                                        </select></td>
                                    <td>
                                        <select x-on:change="changeValue" :data-id="booking['id']" class="rooms"
                                            name="mealPlan" required>
                                            <option value="0" selected>Not Select</option>
                                            <template x-for="i in booking['mealPlans']">
                                                <option x-text="i" x-bind:value="i"></option>
                                            </template>
                                        </select>
                                    </td>
                                    <td x-text="booking['price']*(+booking['noOfRooms']|| 0)"></td>
                                    <td x-text="(booking['price']*(+booking['noOfRooms']|| 0))*.18"></td>
                                    <td
                                        x-text="booking['price']*(+booking['noOfRooms']|| 0) + ((booking['price']*(+booking['noOfRooms']|| 0))*.18)">
                                    </td>
                                </tr>
                            </template>



                            <tr>
                                <td
                                    x-text="'Total Room '+ Object.values(bookings).map(e=>+(e['noOfRooms'] || 0)).reduce((a, b) => a + b, 0);">
                                    total 0</td>
                                <td
                                    x-text="'Adult: '+ Object.values(bookings).map(e=>+(e['adults']|| 0) * +(e['noOfRooms']||0)).reduce((a, b) => a + b, 0) ">
                                    Adult: 0</td>

                                <td
                                    x-text="'Child: '+ Object.values(bookings).map(e=>+(e['childs']|| 0) * +(e['noOfRooms']||0)).reduce((a, b) => a + b, 0)">
                                    Child: 0</td>

                                <td colspan="4">Net Cost</td>
                                <td
                                    x-text="Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)).reduce((a, b) => a + b, 0);">
                                    0</td>
                            </tr>
                            <tr>
                                <td colspan="7">Total GST</td>
                                <td
                                    x-text="Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)*.18).reduce((a, b) => a + b, 0);">
                                    0</td>
                            </tr>
                            <tr>
                                <td colspan="7">Total Discount ( % )
                                    <input x-model="discount" type="number" value="0" id="total">
                                    <span x-text="discount"></span>
                                </td>
                                <td
                                    x-text="'-'+((Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)*.18).reduce((a, b) => a + b, 0) + Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)).reduce((a, b) => a + b, 0)) * (discount/100)) | 0">
                                </td>

                            </tr>

                            <tr>
                                <td colspan="7">Payable Amount</td>
                                <td
                                    x-text="(Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)*.18).reduce((a, b) => a + b, 0) + Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)).reduce((a, b) => a + b, 0))+(Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)*.18).reduce((a, b) => a + b, 0) + Object.values(bookings).map(e=>+(e['price'] || 0)* +(e['noOfRooms']||0)).reduce((a, b) => a + b, 0)) * (discount/100)">
                                    0</td>
                            </tr>
                        </tbody>
                    </table>
                </form>

                <div class="next">
                    <button id="next" type="button" x-on:click="nextStep">Next Step</button>
                </div>
            </div>
        </div>

        <div class="details">
            <button id="guest" onclick="toggleShoww()">GUEST DETAILS</button>
            <div id="grid">
                <div class="detail">
                    <div class="guest">
                        <div id="one">
                            <h3>Booking Source</h3>
                            <select id="text" name="roomtype" required>
                                <option value="">Direct</option>
                                <option value="">Online</option>
                            </select>
                        </div>
                        <div id="one">
                            <h3>Source Type</h3>
                            <input type="text" name="" id="text">
                        </div>
                    </div>
                    <div>
                        <h3>GuestDetails(Search With Name,Email,Nobile)</h3>
                        <input type="text" id="text" placeholder="Add Guest Information">
                    </div>
                    <div>
                        <h3>Special Notes</h3>
                        <textarea name="" id="text" cols="20" rows="5"></textarea>
                    </div>
                </div>
                <div class="detaill">
                    <table id="finaltable">
                        <tbody>
                            <tr>
                                <td colspan="3">Check In Date</td>
                                <td>24-March</td>
                            </tr>
                            <tr>
                                <td colspan="3">Check Out Date</td>
                                <td>25-March</td>
                            </tr>
                            <tr>
                                <td colspan="3">Number Of Rooms</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td colspan="3">Standard Room..</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Executive Suite Room..</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Delux Room</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Mixed Room..</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Net Cost</td>
                                <td>9795</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total GST</td>
                                <td>1175.4</td>
                            </tr>
                            <tr>
                                <td colspan="3">Payable Amount</td>
                                <td>10970</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="final">
            <button id="final" onclick="toggleAtShoww()">FINAL STEP</button>
            <div id="atlast">

                <form>
                    <div class="box">
                        <p>Booking status:</p>
                    </div>
                    <div class="box">
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Confirm Booking</label>
                    </div>
                    <div class="box">
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Hold Booking</label><br>
                    </div>
                    <div class="box"></div>
                    <table id="finaltable">
                        <tbody>
                            <tr>
                                <td colspan="3">Check In Date</td>
                                <td>24-March</td>
                            </tr>
                            <tr>
                                <td colspan="3">Check Out Date</td>
                                <td>25-March</td>
                            </tr>
                            <tr>
                                <td colspan="3">Number Of Rooms</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td colspan="3">Standard Room..</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Executive Suite Room..</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Delux Room</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Mixed Room..</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="3">Net Cost</td>
                                <td>9795</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total GST</td>
                                <td>1175.4</td>
                            </tr>
                            <tr>
                                <td colspan="3">Payable Amount</td>
                                <td>10970</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>

</html>
