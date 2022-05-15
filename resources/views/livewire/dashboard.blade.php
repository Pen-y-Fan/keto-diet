<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>

    <div class="flex flex-col md:flex-row">
        <section>
            <div id="main" class="main-content flex-1 bg-gray-50 pt-12 md:pt-2 pb-24 md:pb-5">
                <div class="p-6">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-2"> {{__('Dashboard')}} {{ now()->format('l jS \\of F Y') }}</h1>
                    <p class="mb-2"> {{ __('Calories per day is now dynamic!') }}</p>
                    <p> {{ __('The other graphs are still static for demonstration, they will be swapped out for real graphs in the future') }}</p>
                </div>
                <div class="flex flex-row flex-wrap flex-grow $t-2">

                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">{{ __('Calories per day') }}</h2>
                            </div>
                            <div class="p-5">
                                <canvas id="chartjs-7" class="chartjs" width="undefined" height="undefined"></canvas>
                                <script>
                                    new Chart(document.getElementById("chartjs-7"), {
                                        "type": "bar",
                                        "data": {
                                            "labels": [@foreach($caleriesPerDay as $day)'{{ $day['date'] }}',@endforeach],
                                            "datasets": [{
                                                "label": "Calories",
                                                "data": [@foreach($caleriesPerDay as $day){{ $day['totalCalories'] }},@endforeach],
                                                "borderColor": "rgb(255, 99, 132)",
                                                "backgroundColor": "rgba(255, 99, 132, 0.2)"
                                            }
                                                // , {
                                                //     "label": "Adsense Clicks",
                                                //     "data": [5, 15, 10, 30],
                                                //     "type": "line",
                                                //     "fill": false,
                                                //     "borderColor": "rgb(54, 162, 235)"
                                                // }
                                            ]
                                        },
                                        "options": {
                                            "scales": {
                                                "yAxes": [{
                                                    "ticks": {
                                                        "beginAtZero": true
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>

                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">{{ __('Graph') }}</h2>
                            </div>
                            <div class="p-5">
                                <canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
                                <script>
                                    new Chart(document.getElementById("chartjs-0"), {
                                        "type": "line",
                                        "data": {
                                            "labels": ["January", "February", "March", "April", "May", "June", "July"],
                                            "datasets": [{
                                                "label": "Views",
                                                "data": [65, 59, 80, 81, 56, 55, 40],
                                                "fill": false,
                                                "borderColor": "rgb(75, 192, 192)",
                                                "lineTension": 0.1
                                            }]
                                        },
                                        "options": {}
                                    });
                                </script>
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>

                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">{{ __('Graph') }}</h2>
                            </div>
                            <div class="p-5">
                                <canvas id="chartjs-1" class="chartjs" width="undefined" height="undefined"></canvas>
                                <script>
                                    new Chart(document.getElementById("chartjs-1"), {
                                        "type": "bar",
                                        "data": {
                                            "labels": ["January", "February", "March", "April", "May", "June", "July"],
                                            "datasets": [{
                                                "label": "Likes",
                                                "data": [65, 59, 80, 81, 56, 55, 40],
                                                "fill": false,
                                                "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"],
                                                "borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"],
                                                "borderWidth": 1
                                            }]
                                        },
                                        "options": {
                                            "scales": {
                                                "yAxes": [{
                                                    "ticks": {
                                                        "beginAtZero": true
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>

                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold uppercase text-gray-600">{{ __('Graph') }}</h5>
                            </div>
                            <div class="p-5">
                                <canvas id="chartjs-4" class="chartjs" width="undefined" height="undefined"></canvas>
                                <script>
                                    new Chart(document.getElementById("chartjs-4"), {
                                        "type": "doughnut",
                                        "data": {
                                            "labels": ["P1", "P2", "P3"],
                                            "datasets": [{
                                                "label": "Issues",
                                                "data": [300, 50, 100],
                                                "backgroundColor": ["rgb(255, 99, 132)", "rgb(54, 162, 235)", "rgb(255, 205, 86)"]
                                            }]
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>

                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Table Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">{{ __('Graph') }}</h2>
                            </div>
                            <div class="p-5">
                                <table class="w-full p-5 text-gray-700">
                                    <thead>
                                    <tr>
                                        <th class="text-left text-blue-900">{{ __('Name') }}</th>
                                        <th class="text-left text-blue-900">{{ __('Side') }}</th>
                                        <th class="text-left text-blue-900">{{ __('Role') }}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>Obi Wan Kenobi</td>
                                        <td>Light</td>
                                        <td>Jedi</td>
                                    </tr>
                                    <tr>
                                        <td>Greedo</td>
                                        <td>South</td>
                                        <td>Scumbag</td>
                                    </tr>
                                    <tr>
                                        <td>Darth Vader</td>
                                        <td>Dark</td>
                                        <td>Sith</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <p class="py-2"><a href="#">{{ __('See More issues...') }}</a></p>

                            </div>
                        </div>
                        <!--/table Card-->
                    </div>


                </div>

                <!-- calories -->
                <div>
                    <div class="visible md:invisible grid grid-cols-7 gap-1 mx-6">
                        @foreach($caleriesPerDay as $dataPerDay)
                            @if ($loop->iteration % 2 === 1 && $loop->iteration < 7)
                                <div class="@if(!$loop->last)col-span-2 @endif">
                                    <p>{{ $dataPerDay['date'] }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="invisible md:visible grid grid-cols-34  gap-1 mx-6">
                        @foreach($caleriesPerDay as $dataPerDay)
                            @if ($loop->iteration % 4 === 1)
                                <div class="@if(!$loop->last)col-span-4 @else col-span-1 @endif">
                                    <p>{{ $dataPerDay['date'] }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="grid grid-cols-7 md:grid-cols-34 gap-1 mb-6 mx-6">
                        @foreach($caleriesPerDay as $dataPerDay)
                            <div class="pb-[100%] text-center border rounded @if($dataPerDay['totalCalories'] > 1700) hover:bg-red-700 bg-red-500 @elseif($dataPerDay['totalCalories'] > 1500) hover:bg-amber-700 bg-amber-500 @elseif($dataPerDay['totalCalories'] === 0) bg-grey-200 @else hover:bg-green-700 bg-green-500 @endif @if( $dataPerDay['date'] === "Saturday" || $dataPerDay['date'] === "Sunday" ) opacity-50 @endif" title="{{ $dataPerDay['date'] }}: calories {{ number_format($dataPerDay['totalCalories']) }}"></div>
                        @endforeach
                    </div>
                </div>
                <!-- /calories -->
            </div>
        </section>
    </div>
</div>
