function clearErrors() {
    const invalids = document.querySelectorAll(".invalid");
    invalids.forEach((invalid) => {
        invalid.classList.remove("invalid");
        invalid.querySelector("span").textContent = "";
    });
}

function madePostRequest(url, data) {
    return fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });
}

document.addEventListener("alpine:init", () => {
    Alpine.data("searchAvailability", () => ({
        checkIn: "",
        checkOut: "",
        isOpen: false,
        toggle() {
            this.isOpen = !this.isOpen;
        },
        _showError(errors) {
            // errors [...[$ref, "message"]]
            errors.forEach((error) => {
                const parent = error[0].parentElement;
                parent.classList.add("invalid");
                parent.querySelector("span").textContent = error[1];
            });
        },
        search(e) {
            // prevent form from submitting
            e.preventDefault();
            clearErrors();
            // validate dates are not valid
            const errors = [];
            if (!this.checkIn)
                errors.push([this.$refs.checkIn, "Check in date is required"]);

            if (!this.checkOut)
                errors.push([
                    this.$refs.checkOut,
                    "Check out date is required",
                ]);

            // validate date range
            if (this.checkIn && this.checkOut) {
                const checkInDate = new Date(this.checkIn);
                const checkOutDate = new Date(this.checkOut);
                if (checkOutDate <= checkInDate) {
                    errors.push([
                        this.$refs.checkOut,
                        "Check out date must be after check in date",
                    ]);
                }
            }

            // if errors, show errors
            if (errors.length) return this._showError(errors);

            madePostRequest("/api/rooms/availability", {
                checkIn: this.checkIn,
                checkOut: this.checkOut,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data["errors"]) {
                        // swal error
                        Swal.fire({
                            title: "Error",
                            text: data["errors"],
                            icon: "error",
                        });
                    }

                    if (data["data"]) {
                        console.log(data["data"]);

                        const btnBanner = document.querySelector(
                            "#searchAvailability button#dates"
                        );
                        btnBanner.textContent = `Stay Dates ( ${this.checkIn} - ${this.checkOut})`;
                        btnBanner.style.background = "#4caf50";
                        btnBanner.style.color = "#fff";
                        // little dark border
                        btnBanner.style.border = "3px solid #2c6f40";

                        // change searchRooms data {isOpen: true}
                        let searchRooms =
                            document.querySelector("#searchRooms");
                        searchRooms._x_dataStack[0].roomCategory = data["data"];
                        searchRooms._x_dataStack[0].isOpen = true;
                    }
                });
        },
    }));

    Alpine.data("searchRooms", () => ({
        isOpen: false,
        bookings: {},
        changeValue(e) {
            let prop = e.target.attributes["data-id"].value;
            this.bookings[prop][e.target.name] = e.target.value;
        },
        toggle() {
            this.isOpen = !this.isOpen;
        },
        selectNoOfRooms(e) {
            if (e.target.value == 0) return delete this.bookings[e.target.name];
            this.bookings[e.target.name] = {
                ...(this.bookings[e.target.name] ||
                    this.roomCategory[e.target.name]),
                noOfRooms: e.target.value,
            };
        },
        discount: 0,
        formSubmit(e) {
            e.preventDefault();
        },
        nextStep(e) {
            madePostRequest("/api/rooms/bookings", {
                bookings: this.bookings,
                discount: this.discount,
            })
                .then((res) => res.json())
                .then((res) => {
                    console.log(res);
                });
        },
        roomCategory: {},
    }));
});
