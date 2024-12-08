document.addEventListener('DOMContentLoaded', function() {
    let calendarContainer = document.getElementById('calendar');
    let calendarHeader = document.getElementById('calendar-month');
    let currentDate = new Date();
    // crea un arreglo de varias fechas en octubre de 2024
    //convertir el array de arriba pero ahora en objetos tipo Date
    
    const quotesDatesFormatted = quotesDates.map(date => {
            const dateString = date + 'T00:00:00';
            return new Date(dateString).toDateString();
        });

    const evetsDatesFormated = eventsDates.map(date => {
            const dateString = date + 'T00:00:00';
            return new Date(dateString).toDateString();
        });



    const updateCalendar = () => {
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth();
        let currentDay = currentDate.getDate();
        const firstDay = new Date(currentYear, currentMonth, 0);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const totalDays = lastDay.getDate();
        const firstDayIndex = firstDay.getDay();
        const lastDayIndex = lastDay.getDay();
        const montYearString = currentDate.toLocaleDateString('default', { month: 'long', year: 'numeric' });
        calendarHeader.innerHTML = montYearString;

    
    
    
        let datesHTML = '';
    
        for(let i = firstDayIndex; i > 0; i--) {
            const preveDate = new Date(currentYear, currentMonth, 0 - i + 1);
            datesHTML += `<div class="date inactive">${preveDate.getDate()}</div>`;
        }
        for(let i = 1; i <= totalDays; i++) {
            const date = new Date(currentYear, currentMonth, i);
            const activeClass = date.toDateString() === new Date().toDateString() ? 'active' : '';
            const apartedDateClass = quotesDatesFormatted.includes(date.toDateString()) ? 'aparted' : '';
            const eventDateClass = evetsDatesFormated.includes(date.toDateString()) ? 'event' : '';
            datesHTML += `<div class="date ${activeClass} ${apartedDateClass} ${eventDateClass}">${i}</div>`;
        }
        if(lastDayIndex !== 0){
            for(let i =1; i <= 7 - lastDayIndex; i++) {
                const nexDate = new Date(currentYear, currentMonth + 1, i);
                datesHTML += `<div class="date inactive">${nexDate.getDate()}</div>`;
            }
        }
        datesHTML += ''
        calendarContainer.innerHTML = datesHTML;
    }
    if (document.getElementById('next')) {
        document.getElementById('next').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar();
        });
    }
    if (document.getElementById('prev')){
        document.getElementById('prev').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar();
        });
    }




    updateCalendar();




});


