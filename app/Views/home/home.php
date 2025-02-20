<div class="container py-4 my-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3 section-with-background">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Book A Bus</h1>
            <p class="col-md-8 fs-4">Want to travel around the country, Why not use our website to book ticket from home.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form action="search" method="get" class="my-form" id="bus-search-form">
                <div class="search-box">
                    <div class="d-flex align-items-center mb-3">
                        <input type="radio" name="trip_type" id="oneWay" value="oneWay" checked>
                        <label for="oneWay" class="ms-2">One Way</label>
                        <input type="radio" name="trip_type" id="roundWay" value="roundWay" class="ms-3">
                        <label for="roundWay" class="ms-2">Round Way</label>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3" style="position: relative;">
                            <label class="form-label">From</label>
                            <div class="input-group">
                                <input required type="text" class="form-control custom-input" placeholder="Enter City" name="origin" id="origin-input">
                            </div>
                            <div id="origin-search-results" class="search-results-container"></div>
                        </div>
                        <div class="col-md-3" style="position: relative;">
                            <label class="form-label">To</label>
                            <div class="input-group">
                                <input required type="text" class="form-control custom-input" placeholder="Enter destination" name="destination" id="destination-input">
                            </div>
                            <div id="destination-search-results" class="search-results-container"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Journey Date</label>
                            <input required type="text" class="custom-input form-control" name="date" id="date-input" placeholder="Select Date">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Return Date</label>
                            <input type="text" class="custom-input form-control rdate_input" name="rdate" id="rdate-input" placeholder="Select Date">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100" type="submit">SEARCH</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-12 mainhome" style="padding: 20px;">
            <div class="content" style="text-align: center;">
                <h1>Popular Destinations</h1>
                <p>Travel Arround the countries most popular places </p>
            </div>
         
        </div>
        <div class="col-4">
            <ul>
                <li class="setsearchform" data-from="Dhaka" data-to="Chattogram"><i class="fas fa-map-marker-alt"></i> Dhaka to Chattogram</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Cox's Bazar"><i class="fas fa-map-marker-alt"></i> Dhaka to Cox's Bazar</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Sylhet"><i class="fas fa-map-marker-alt"></i> Dhaka to Sylhet</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Khulna"><i class="fas fa-map-marker-alt"></i> Dhaka to Khulna</li>
            </ul>
        </div>
        <div class="col-4">
            <ul>
                <li class="setsearchform" data-from="Dhaka" data-to="Rajshahi"><i class="fas fa-map-marker-alt"></i> Dhaka to Rajshahi</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Barisal"><i class="fas fa-map-marker-alt"></i> Dhaka to Barisal</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Rangpur"><i class="fas fa-map-marker-alt"></i> Dhaka to Rangpur</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Mymensingh"><i class="fas fa-map-marker-alt"></i> Dhaka to Mymensingh</li>
            </ul>
        </div>
        <div class="col-4">
            <ul>
                <li class="setsearchform" data-from="Dhaka" data-to="Comilla"><i class="fas fa-map-marker-alt"></i> Dhaka to Comilla</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Noakhali"><i class="fas fa-map-marker-alt"></i> Dhaka to Noakhali</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Feni"><i class="fas fa-map-marker-alt"></i> Dhaka to Feni</li>
                <li class="setsearchform" data-from="Dhaka" data-to="Bogura"><i class="fas fa-map-marker-alt"></i> Dhaka to Bogura</li>
            </ul>
        </div>
    </div>
</div>

