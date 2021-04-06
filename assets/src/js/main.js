import Chart from 'chart.js/auto';
import $ from 'jquery';
import 'bootstrap';

$(document).ready(function() {

    $('.submit-form-span').on('click', function(e) {
        $(this).parent().find('.lectureStudentDetail').submit();
    })

    $('.lectureStudentDetail').on('submit', function(e) {
        e.preventDefault();

        var modal = $('#exampleModal');
        var modalContent = modal.find( '.modal-body' );

        var student_id = $(this).find('input[name=student_id]').val();
        var lecture_id = $(this).find('input[name=lecture_id]').val();
        var url = BASE_URL + `/student/${student_id}/lecture/${lecture_id}`;

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                data = JSON.parse(data);
                if( data ) {
                    var output = '<table class="table">';
                    data.forEach(element => {
                        output += '<tr>';
                        output += '<td>' + element.status + '</td>';
                        output += '<td>' + element.time + '</td>';
                        output += '</tr>';
                    });
    
                    output += '</table>';
                } else {
                    var output = "Nothing to be found here";
                }
                modalContent.html(output);
                modal.modal()
            },
            fail: function(err) {
                console.log(err)
            }

        })
    })


    if(lectures) {
        var ctx = document.getElementById('myChart');

        var labels = [];
        var data = [];

        lectures.forEach( (lecture,index) => {
            labels.push( ++index )
            data.push(lecture.numOfStudents)

        })

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Účasť',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }


})