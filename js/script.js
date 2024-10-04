    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k]
                events.push({ id: row.id, 
                            full_name: row.full_name, 
                            email: row.email, 
                            phone_number: row.phone_number, 
                            telephone_number:row.telephone_number, 
                            date_check_in: row.date_check_in, 
                            date_check_out: row.date_check_out, 
                            service: row.service_id, 
                            message: row.message, 
                            mode_of_payment: row.mode_of_payment_id, 
                            evidence: row.evidence });
            })
        }
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            selectable: true,
            themeSystem: 'bootstrap',
            //Random default events
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var id = info.event.id
                if (!!scheds[id]) {
                    _details.find('#full_name').text(scheds[id].full_name)
                    _details.find('#email').text(scheds[id].email)
                    _details.find('#phone_number').text(scheds[id].phone_number)
                    _details.find('#telephone_number').text(scheds[id].telephone_number)
                    _details.find('#date_check_in').text(scheds[id].date_check_in)
                    _details.find('#date_check_out').text(scheds[id].date_check_out)
                    _details.find('#service_id').text(scheds[id].service)
                    _details.find('#message').text(scheds[id].message)
                    _details.find('#mode_of_payment_id').text(scheds[id].mode_of_payment)
                    _details.find('#evidence').text(scheds[id].evidence)
                    _details.find('#edit,#delete').attr('data-id', id)
                    _details.modal('show')
                } else {
                    alert("Event is undefined");
                }
            },
            eventDidMount: function(info) {
                // Do Something after events mounted
            },
            editable: true
        });

        calendar.render();

        // Form reset listener
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('')
            $(this).find('input:visible').first().focus()
        })

        // Edit Button
        $('#edit').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                var _form = $('#schedule-form')
                console.log(String(scheds[id].date_check_in), String(scheds[id].date_check_in).replace(" ", "\\t"))
                _form.find('[name="id"]').val(id)
                _form.find('[name="full_name"]').val(scheds[id].full_name)
                _form.find('[name="email"]').val(scheds[id].email)
                _form.find('[name="phone_number"]').val(scheds[id].phone_number)
                _form.find('[name="telephone_number"]').val(scheds[id].telephone_number)
                _form.find('[name="date_check_in"]').val(String(scheds[id].date_check_in).replace(" ", "T"))
                _form.find('[name="date_check_out"]').val(String(scheds[id].date_check_out).replace(" ", "T"))
                _form.find('[name="service_id"]').val(scheds[id].service)
                _form.find('[name="message"]').val(scheds[id].message)
                _form.find('[name="mode_of_payment_id"]').val(scheds[id].mode_of_payment)
                _form.find('[name="evidence"]').val(scheds[id].evidence)

                $('#event-details-modal').modal('hide')
                _form.find('[name="full_name"]').focus()
            } else {
                alert("Event is undefined");
            }
        })

        // Delete Button / Deleting an Event
        $('#delete').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                location.href = "./delete_schedule.php?id=" + id;
            } else {
                alert("Event is undefined");
            }
        })

        // $('#delete').click(function () {
        //     var id = $(this).attr('data-id');
        //     if (!!scheds[id]) {
        //         // Show the delete confirmation modal
        //         $('#deleteConfirmationModal').modal('show');

        //         // Handle the confirmation
        //         $('#confirmDelete').click(function () {
        //         // User confirmed deletion, proceed with deletion
        //             location.href = "./delete_schedule.php?id=" + id;
        //         });
        //     } else {
        //         alert("Event is undefined");
        //     }
        // });
    })