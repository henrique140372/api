"use strict";

const Analytics = {

    earnByMonthly: {

        uniqName: 'earnings_by_month',
        dateRangePicker: null,
        month: null,
        year: null,
        chart: null,
        userId: 0,

        init: function () {
            let self = this;

            self.month = moment().format('M');
            self.year = moment().format('YYYY');

            if(typeof USER_ID !== 'undefined') {
                self.userId =  USER_ID;
            }

            if(typeof EarningsByMonthly_LineChart != 'undefined'){
                self.chart = EarningsByMonthly_LineChart;
                self.dateRangePicker = $('#earnings-by-monthly-datetime-picker');
                self.bindDataRangePicker();
                self.updateChart();
            }
        },
        updateChart: function (){

            let self = this;


            $.ajax({

                url: BASE_URL  + '/statistics/json',
                type: 'GET',
                contentType: "application/json",
                dataType: "json",
                data: {
                    chart: self.uniqName,
                    month: self.month,
                    year: self.year,
                    user: self.userId
                },
                success: function(response) {

                    let data = response;
                    let stars = [];

                    if(!$.isEmptyObject(data)){

                        Object.keys(data).forEach(function(key) {
                            let val = data[key];
                            stars.push({
                                "x": val.date,
                                "y": val.stars
                            });
                        });
                    }

                    setTimeout(function (){
                        self.chart.updateSeries([{
                            name: 'Earned Stars',
                            data: stars
                        }]);
                    }, 900);

                },
                error: function (jqXHR, exception){
                    alert('Visits chart data loading failed');
                },
                complete: function() {

                    setTimeout(function (){
                        self.noData();
                    }, 900)


                }
            });


        },
        loading: function (){
            this.chart.updateSeries([]);
            this.chart.updateOptions({
                noData: {
                    text: 'loading...'
                }
            })
        },
        noData: function (){
            this.chart.updateOptions({
                noData: {
                    text: 'No Data Found'
                }
            })
        },
        bindDataRangePicker: function (){

            let self = this;

            self.dateRangePicker.daterangepicker({
                parentEl: ".datetimepicker-wrap",
                singleDatePicker: true,
                showDropdowns: true,
                minDate: '1/2022',
                maxDate: moment().format('M/YYYY'),
                autoUpdateInput: true,
                opens: "left",
                locale: {
                    format: 'M/YYYY'
                }
            });

            self.dateRangePicker.on('show.daterangepicker', function(e, picker) {
                picker.container.find('.calendar-table').addClass('my-only');
            });
            self.dateRangePicker.on('hide.daterangepicker', function(e, picker) {
                picker.container.find('.calendar-table').removeClass('my-only');
            });
            self.dateRangePicker.on('apply.daterangepicker', function(e, picker) {
                self.filtered(picker);
            });



        },
        filtered: function (picker){

            let self = this;

            self.month = parseInt(picker.container.find('.monthselect').val()) + 1;
            self.year = parseInt(picker.container.find('.yearselect').val());

            picker.setStartDate(self.month + '/' + self.year);

            //update chart
            self.loading();
            this.updateChart();

        },
    },
    visitorsByMonthly: {

        uniqName: 'visitors_by_month',
        dateRangePicker: null,
        month: null,
        year: null,
        chart: null,
        isRef: 0,
        movieId: 0,
        userId: 0,

        init: function () {
            let self = this;

            self.month = moment().format('M');
            self.year = moment().format('YYYY');

            self.isRef = $("#line-chart-visitors-by-monthly").attr('data-is-ref') === 'true' ? 1 : 0;

            if(typeof MOVIE_ID !== 'undefined') {
                self.movieId =  MOVIE_ID;
            }

            if(typeof USER_ID !== 'undefined') {
                self.userId =  USER_ID;
            }

            if(typeof ReferralsByMonthly_LineChart != 'undefined'){
                self.chart = ReferralsByMonthly_LineChart;
                self.dateRangePicker = $('#visitors-by-monthly-datetime-picker');
                self.bindDataRangePicker();
                self.updateChart();
            }


        },
        updateChart: function (){

            let self = this;

            $.ajax({

                url: BASE_URL  + '/statistics/json',
                type: 'GET',
                contentType: "application/json",
                dataType: "json",
                data: {
                    chart: self.uniqName,
                    month: self.month,
                    year: self.year,
                    movie: self.movieId,
                    is_ref: self.isRef,
                    user: self.userId
                },
                success: function(response) {

                    let data = response;
                    let visits = [];
                    let uniqVisits = [];

                    if(!$.isEmptyObject(data)){

                        Object.keys(data).forEach(function(key) {
                            let val = data[key];

                            visits.push({
                                "x": val.date,
                                "y": val.visits
                            });
                            uniqVisits.push({
                                "x": val.date,
                                "y": val.uniqVisits
                            });
                        });


                        setTimeout(function (){
                            self.chart.updateSeries([{
                                name: 'total visits',
                                data: visits
                            },{
                                name: 'unique visits',
                                data: uniqVisits
                            }]);
                        }, 900);
                    }



                },
                error: function (jqXHR, exception){
                    alert('Ref chart data loading failed');
                },
                complete: function() {

                    setTimeout(function (){
                        self.noData();
                    }, 900);

                }
            });


        },
        loading: function (){
            this.chart.updateSeries([]);
            this.chart.updateOptions({
                noData: {
                    text: 'loading...'
                }
            })
        },
        noData: function (){
            this.chart.updateOptions({
                noData: {
                    text: 'No Data Found'
                }
            })
        },
        bindDataRangePicker: function (){

            let self = this;

            self.dateRangePicker.daterangepicker({
                parentEl: ".datetimepicker-wrap",
                singleDatePicker: true,
                showDropdowns: true,
                minDate: '1/2022',
                maxDate: moment().format('M/YYYY'),
                autoUpdateInput: true,
                opens: "left",
                locale: {
                    format: 'M/YYYY'
                }
            });

            self.dateRangePicker.on('show.daterangepicker', function(e, picker) {
                picker.container.find('.calendar-table').addClass('my-only');
            });
            self.dateRangePicker.on('hide.daterangepicker', function(e, picker) {
                picker.container.find('.calendar-table').removeClass('my-only');
            });
            self.dateRangePicker.on('apply.daterangepicker', function(e, picker) {
                self.filtered(picker);
            });

        },
        filtered: function (picker){

            let self = this;

            self.month = parseInt(picker.container.find('.monthselect').val()) + 1;
            self.year = parseInt(picker.container.find('.yearselect').val());

            picker.setStartDate(self.month + '/' + self.year);

            //update chart
            self.loading();
            this.updateChart();

        },
    },
    visitorsByCountriesMap: {

        uniqName: 'visitors_by_country',
        dateRangePicker: null,
        startDate: null,
        endDate: null,
        map: null,
        isUnique: false,
        data: {},
        movieId: 0,
        isRef: false,
        userId: 0,

        init: function () {
            let self = this;

            let visitorsMap = $('#map-visitors-by-countries');
            self.isRef = visitorsMap.attr('data-is-ref') === 'true' ? 1 : 0;
            if(typeof MOVIE_ID !== 'undefined') {
                self.movieId =  MOVIE_ID;
            }
            if(typeof USER_ID !== 'undefined') {
                self.userId =  USER_ID;
            }
            if(visitorsMap.length === 1){
                self.map = visitorsMap;
                self.dateRangePicker = $('#visitors-by-countries-datetime-picker');
                self.bindDataRangePicker();

                // self.bind('#map-referrals-by-countries', 'showLabel', 'labelShow.jqvmap')
                // self.bind('#mapVisitsType', 'visitsTypeSelected', 'change')

                self.updateMap();

            }
        },
        showLabel: function (event, label, code){
            if (this.data[code] > 0) {
                label.append(': <strong>' + this.data[code] + '</strong>');
            }
        },
        updateMap: function (){

            let self = this;
            let mapRegionNode = $('.jqvmap-region');
            self.load();

            $.ajax({

                url: BASE_URL  + '/statistics/json',
                type: 'GET',
                contentType: "application/json",
                dataType: "json",
                data: {
                    chart: self.uniqName,
                    start_date: self.startDate,
                    end_date: self.endDate,
                    movie: self.movieId,
                    is_ref: self.isRef,
                    user: self.userId
                },
                success: function(response) {

                    setTimeout(function (){
                        self.data = chart_data = response;
                        mapRegionNode.attr('fill', '#78828c1a');
                        mapRegionNode.attr('original', '#78828c1a');
                        self.map.vectorMap('set', 'values', self.data );
                    }, 700);

                },
                error: function (jqXHR, exception){
                    alert('Visitors map data loading failed');
                },
                complete: function() {
                    setTimeout(function (){
                        self.load();
                    }, 900)
                }
            });


        },
        filtered: function (picker){

            this.startDate = picker.startDate.format('DD-MM-YYYY');
            this.endDate = picker.endDate.format('DD-MM-YYYY');

            this.updateMap();

        },
        bindDataRangePicker: function (){

            let self = this;

            self.dateRangePicker.daterangepicker({
                parentEl: ".ref-datetimepicker-wrap",
                showDropdowns: true,
                opens : "left",
                startDate : moment().startOf('month'),
                EndDate : moment().endOf('month'),
                minDate: '1/1/2022',
                maxDate: moment().format('D/M/YYYY'),
                autoUpdateInput: true,
                locale: {
                    format: 'D/M/YYYY'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            let picker = self.dateRangePicker.data('daterangepicker');

            self.startDate = picker.startDate.format('DD-MM-YYYY');
            self.endDate = picker.endDate.format('DD-MM-YYYY');


            self.dateRangePicker.on('apply.daterangepicker', function(e, picker) {
                self.filtered(picker);
            });


        },
        load: function (){
            let cardElement = this.map.closest('.x_content');
            if(cardElement.length > 0){
                cardElement.toggleClass('card-loading');
            }
        },
        bind: function(selector, action, event = 'click'){
            $(document).on(event,selector,function(self) {
                return function (e){
                    return self[action](e);
                }
            }(this));
        }
    },
    bind: function(selector, action, event = 'click'){
        $(document).on(event,selector,function(self) {
            return function (e){
                return self[action](e);
            }
        }(this));
    }

}