// JS dyal reservation
document.addEventListener("DOMContentLoaded", function () {
    const serviceButtons = document.querySelectorAll(".service-btn");

    const serviceInput = document.getElementById("service_id");
    const subServiceInput = document.getElementById("sub_service_id");
    const timeInput = document.getElementById("reservation_time");
    const dateInput = document.getElementById("reservation_date");

    const subServiceBox = document.getElementById("subServiceBox");
    const timeSlotsBox = document.getElementById("timeSlots");

    const summaryService = document.getElementById("summary-service");
    const summarySubService = document.getElementById("summary-sub-service");
    const summaryDuration = document.getElementById("summary-duration");
    const summaryPrice = document.getElementById("summary-price");
    const summaryDate = document.getElementById("summary-date");
    const summaryTime = document.getElementById("summary-time");

    function resetSubService() {
        if (subServiceInput) subServiceInput.value = "";
        if (summarySubService) summarySubService.textContent = "--";
    }

    function resetTime() {
        if (timeInput) timeInput.value = "";
        if (summaryTime) summaryTime.textContent = "--";
        if (timeSlotsBox) {
            timeSlotsBox.innerHTML = '<p class="text-muted">Choisissez un service et une date.</p>';
        }
    }

    function showSubServices(serviceId) {
        const service = window.servicesData.find(s => s.id == serviceId);

        subServiceBox.innerHTML = "";
        resetSubService();

        if (!service || !service.sub_services || service.sub_services.length === 0) {
            subServiceBox.innerHTML = '<p class="text-muted">Aucun type disponible pour ce service.</p>';
            return;
        }

        service.sub_services.forEach(sub => {
            const button = document.createElement("button");
            button.type = "button";
            button.className = "sub-service-btn";

            const priceText = sub.price ? sub.price + " DH" : "Prix à définir";
            const durationText = sub.duration_minutes ? sub.duration_minutes + " min" : "-- min";

            button.innerHTML = `
                ${sub.name}
                <span>${durationText} · ${priceText}</span>
            `;

            button.addEventListener("click", function () {
                document.querySelectorAll(".sub-service-btn").forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                subServiceInput.value = sub.id;

                summarySubService.textContent = sub.name;
                summaryDuration.textContent = durationText;
                summaryPrice.textContent = priceText;
            });

            subServiceBox.appendChild(button);
        });
    }

    function loadAvailableSlots() {
        const serviceId = serviceInput.value;
        const date = dateInput.value;

        if (!timeSlotsBox) return;

        if (!serviceId || !date) {
            timeSlotsBox.innerHTML = '<p class="text-muted">Choisissez un service et une date.</p>';
            return;
        }

        fetch(`/available-slots?service_id=${serviceId}&date=${date}`)
            .then(response => response.json())
            .then(slots => {
                timeSlotsBox.innerHTML = "";

                if (slots.length === 0) {
                    timeSlotsBox.innerHTML = '<p class="text-danger">Aucun créneau disponible pour cette date.</p>';
                    return;
                }

                slots.forEach(slot => {
                    const button = document.createElement("button");
                    button.type = "button";
                    button.textContent = slot;
                    button.dataset.time = slot;

                    button.addEventListener("click", function () {
                        document.querySelectorAll("#timeSlots button").forEach(btn => btn.classList.remove("active"));
                        this.classList.add("active");

                        timeInput.value = slot;
                        summaryTime.textContent = slot;
                    });

                    timeSlotsBox.appendChild(button);
                });
            });
    }

    serviceButtons.forEach(button => {
        button.addEventListener("click", function () {
            serviceButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            serviceInput.value = this.dataset.id;

            summaryService.textContent = this.dataset.name;
            summaryDuration.textContent = this.dataset.duration + " min";
            summaryPrice.textContent = "--";

            showSubServices(this.dataset.id);
            resetTime();
            loadAvailableSlots();
        });
    });

    if (dateInput) {
        dateInput.addEventListener("change", function () {
            summaryDate.textContent = this.value;

            timeInput.value = "";
            summaryTime.textContent = "--";

            loadAvailableSlots();
        });
    }

    const reservationForm = document.getElementById("reservationForm");

    if (reservationForm) {
        reservationForm.addEventListener("submit", function (event) {
            if (!serviceInput.value) {
                event.preventDefault();
                alert("Choisissez un service.");
                return;
            }

            if (!subServiceInput.value) {
                event.preventDefault();
                alert("Choisissez un type de soin.");
                return;
            }

            if (!timeInput.value) {
                event.preventDefault();
                alert("Choisissez un créneau.");
                return;
            }
        });
    }
});