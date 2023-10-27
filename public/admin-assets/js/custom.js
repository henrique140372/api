(function($) {

    "use strict";

    $(document).ready(function() {

        init_bulk_import();
        init_links_groups();
        init_autoload();
        init_tv_shows_selection();
        init_data_list_datatable();
        init_discover();
        init_suggestion();
        init_links_approval();

        if($('.summernote').length > 0){
            $('.summernote').summernote({
                height: 300
            });
        }

    });

    $(document).on('click', '.del-item', function (){

        let delConfirmModal = $('#del-confirm-modal');
        let url = $(this).attr('data-url');
        delConfirmModal.find('.del-link').attr('href', url);
        delConfirmModal.modal('show');

    });


    $(".payout-status").on('change', function (){

        let status = this.value;
        let id = $(this).closest('tr').attr('data-id');

        $.ajax({
            url : BASE_URL + '/payouts/update_status/' + id,
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest'},
            data: {
                'status' : status
            },
            dataType: "JSON",
            success: function(data)
            {

                if(! data.success) {

                    alert('Unable to update payout status');

                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error occurred');
            }
        });

    });

    $(".select2_multiple, #select-genres").select2({

    });

    function init_bulk_import()
    {
        let summary = {
            'init_queried' : 0,
            'queried' : 0,
            'success' : 0,
            'exist' : 0,
            'failed' : 0
        };

        let type = 'movie';
        let imdbIds = [];
        let ajaxData = [];
        let links = [];

        let importBtn = null;
        let textarea = null;
        let isRunning = false;


        $(window).bind('beforeunload', function(){
            if( isRunning ){
                return 'Are you sure you want to leave?';
            }
        });

        function appendResults( data )
        {

            let listItem = '<li class="list-group-item py-1">\n' +
                '<b class="uniq_id"></b> - ' +
                '<span class="title"></span>' +
                '<a href="#" class="float-right edit-link" target="_blank">' +
                'Edit' +
                '</a>' +
                '</li>';

            let listItemError = '<li class="list-group-item py-1">\n' +
                '<b class="uniq_id text-danger"></b> - ' +
                '<span class="error"></span>' +
                '</li>';

            $.each(data, function(index, value) {

                if( value.success ) {

                    let item = $(listItem);
                    let edit_link = '/admin/' + value.type + '/edit/' + value.data.id;

                    item.find('.uniq_id').text( index );
                    item.find('.title').text( value.data.title );
                    item.find('.edit-link').attr( 'href', edit_link );

                    if(! value.is_exist ){
                        $("#success-list").append( item  );
                    }else{
                        $("#exist-list").append( item  );
                    }


                    if(value.type === 'series' ){

                        $.each(value.data.episodes, function(index, value) {
                            appendResults(value.episodes);
                        });

                    }

                    if(! value.is_exist ){
                        updateImportedLinks( value.data.imdb_id );
                    }


                }else{

                    let item = $(listItemError);
                    item.find('.uniq_id').text( index );
                    item.find('.error').text( value.error );

                    $("#failed-list").append( item  );
                }

                let status = '';
                if(value.success){
                    if(! value.is_exist){
                        status = 'success';
                    }else{
                        status = 'exist';
                    }
                }else{
                    status = 'failed';
                }
                summary[status] += 1;

                updateSummary();

            });





        }

        function updateImportedLinks( imdb_id )
        {
            let link = get_short_embed_link( imdb_id );
            links.push( link );

            $("#imported-links").text( links.join('\n') );

        }

        function updateSummary()
        {
            $('.num-of-success').text( summary.success );
            $('.num-of-exist').text( summary.exist );
            $('.num-of-failed').text( summary.failed );
        }

        function getQueriedIds()
        {
            let data = '';
            if(type === 'movies'){
                data = ajaxData.splice(0, 3);
                data = data.join(',');
            }else{
                data = ajaxData.shift();
            }
            return data;
        }

        function cleanIdsData()
        {
            let results = [];

            imdbIds.forEach(function (item, index) {
                results.push( item );
            });

            ajaxData = results;
        }

        function isQueryEmpty()
        {
            return ajaxData.length === 0;
        }

        function importMovie(  )
        {


            if(! isQueryEmpty()){

                $.ajax({
                    url : BASE_URL + '/ajax/import',
                    type: "GET",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        'uniq_ids': getQueriedIds(),
                        'type' : type
                    },
                    dataType: "JSON",
                    success: function(data)
                    {

                        if(data.success) {
                            appendResults( data.data );
                        }else{
                            alert('something went wrong');
                        }

                    },
                    complete: function () {

                        importMovie();


                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    }
                });

            }else{
                //done
                canceled();
            }



        }

        function canceled()
        {
            btn_loaded( importBtn );
            textarea.val( '' );
            textarea.removeAttr('disabled');
            isRunning = false;
        }

        function start()
        {
            isRunning = true;

            //lock button and textarea
            btn_loading( importBtn );
            textarea.attr('disabled', 'disabled');

            //update summary
            summary.queried = summary.init_queried = ajaxData.length;
            updateSummary();

            //start import movie
            importMovie();
        }

        $("#run-importer").on('click', function (){

            type = $('[name="type"]').val();
            textarea = $('#ids-list');
            importBtn = $(this);

            imdbIds = textarea.val().replace(/ /g, '');
            imdbIds = imdbIds.replace(/(\r\n\t\b|\n|\r|\t|\b)/gm,'').split(',');
            imdbIds = $.grep(imdbIds,function(n){ return n === 0 || n });


            if(imdbIds.length > 0) {
                cleanIdsData();
                start();
            }else{
                alert('Please enter imdb/ tmdb ids');
            }

        });


        $('#cancel-import-process').on('click', function (){

            if(ajaxData.length > 0) {
                let $this = $(this);
                btn_loading( $this );

                ajaxData = [];
                canceled();

                setTimeout(function (){
                    btn_loaded( $this );
                }, 2000)
            }

        });

    }


    function init_links_approval()
    {
        $('.link-approved, .link-rejected').on('click', function (){

            let $this = $(this);
            let mainElement = $this.closest('.main-form-group');
            let isApproved = $this.hasClass('link-approved');

            // enable loader
            btn_loading( $this );

            let linkId = mainElement.find('.link-id').val();
            $.ajax({
                url : BASE_URL + '/links/update_status/' + linkId,
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest'},
                data: {
                    'is_approved' : + isApproved
                },
                dataType: "JSON",
                success: function(data)
                {
                    if(data.success){

                        setTimeout(function (){

                            updateStats(mainElement, isApproved);

                        }, 2000);

                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {

                },
                complete: function ()
                {
                    setTimeout(function (){
                        btn_loaded( $this );
                    }, 1900);
                }
            });

        });


        function updateStats(elmt, isActive = false)
        {
            let st_class;
            let st;

            if( isActive ){

                elmt.find('.link-approved').attr('disabled', 'disabled');
                elmt.find('.link-rejected').removeAttr('disabled');

                st_class = 'text-success';
                st = 'Active';

            }else{

                elmt.find('.link-rejected').attr('disabled', 'disabled');
                elmt.find('.link-approved').removeAttr('disabled');

                st_class = 'text-danger';
                st = 'Rejected';
            }

            elmt.find('.status-val').text( st );
            elmt.find('.status-val').removeClass('text-success text-danger text-warning');
            elmt.find('.status-val').addClass( st_class );
        }


    }

    function init_links_groups()
    {
        $(document).on('click', '#clone-st-group', function () {

            let clonedGroup = $('#st-group-content .st-group').first().clone();
            let totalGroups = $('.st-group').length;
            let uniqId = totalGroups + 1;

            if(totalGroups > 0) {

                clonedGroup.find('.link').val('');
				clonedGroup.find('.link').removeAttr('readonly');
                clonedGroup.find('.link').attr('name', 'st_links['+ uniqId +'][url]');
                clonedGroup.find('.quality').attr('name', 'st_links['+ uniqId +'][quality]');

                clonedGroup.find('input[type="hidden"]').remove();
                clonedGroup.find('.link-meta-info, .meta-bottom-right, .input-group-btn').remove();
                clonedGroup.find('label:first').text('Link ' + uniqId);
                clonedGroup.find('select').prop('selectedIndex', 0);

                $("#st-group-content").append( clonedGroup );

            }

        });

        $(document).on('click', '#clone-direct-dl-group', function () {

            let clonedGroup = $('.direct-dl-group').first().clone();
            let totalGroups = $('.direct-dl-group').length;
            let uniqId = totalGroups + 1;

            if(clonedGroup.length > 0) {

                clonedGroup.find('.link').val('');
                clonedGroup.find('.link').attr('name', 'direct_dl_links['+ uniqId +'][url]');

                clonedGroup.find('.resolution').val('');
                clonedGroup.find('.resolution').attr('name', 'direct_dl_links['+ uniqId +'][resolution]');

                clonedGroup.find('.quality').val('');
                clonedGroup.find('.quality').attr('name', 'direct_dl_links['+ uniqId +'][quality]');

                clonedGroup.find('.size-val').val('');
                clonedGroup.find('.size-val').attr('name', 'direct_dl_links['+ uniqId +'][size_val]');
                clonedGroup.find('.size-label').attr('name', 'direct_dl_links['+ uniqId +'][size_lbl]');

                clonedGroup.find('input[type="hidden"]').remove();
                clonedGroup.find('.link-meta-info, .meta-bottom-right, .input-group-btn').remove();
                clonedGroup.find('label:first').text('Link ' + uniqId);

                $("#direct-dl-group-content").append( clonedGroup );

            }
        });

        $(document).on('click', '#clone-torrent-dl-group', function () {

            let clonedGroup = $('.torrent-dl-group').first().clone();
            let totalGroups = $('.torrent-dl-group').length;
            let uniqId = totalGroups + 1;

            if(clonedGroup.length > 0) {

                clonedGroup.find('.link').val('');
                clonedGroup.find('.link').attr('name', 'torrent_dl_links['+ uniqId +'][url]');

                clonedGroup.find('.resolution').val('');
                clonedGroup.find('.resolution').attr('name', 'torrent_dl_links['+ uniqId +'][resolution]');

                clonedGroup.find('.quality').val('');
                clonedGroup.find('.quality').attr('name', 'torrent_dl_links['+ uniqId +'][quality]');

                clonedGroup.find('.size-val').val('');
                clonedGroup.find('.size-val').attr('name', 'torrent_dl_links['+ uniqId +'][size_val]');
                clonedGroup.find('.size-label').attr('name', 'direct_dl_links['+ uniqId +'][size_lbl]');

                clonedGroup.find('input[type="hidden"]').remove();
                clonedGroup.find('.link-meta-info, .meta-bottom-right, .input-group-btn').remove();
                clonedGroup.find('label:first').text('Link ' + uniqId);

                $("#torrent-dl-group-content").append( clonedGroup );

            }
        });
    }

    function init_autoload()
    {
        $("#load-tv-data").on('click', function (){

            let $this = $(this);

            let loadId = null;

            let imdb_id = $.trim( $('input[name="imdb_id"]').val() );
            let tmdb_id = $.trim( $('input[name="tmdb_id"]').val() );

            if(imdb_id) loadId = imdb_id;
            if(! imdb_id && tmdb_id) loadId = tmdb_id;


            if(loadId !== null){
                $.ajax({
                    url : BASE_URL + '/ajax/autoload/load_tv_data',
                    type: "GET",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        'id' : loadId
                    },
                    dataType: "JSON",
                    beforeSend: function ()
                    {
                        btn_loading( $this );
                    },
                    success: function(data)
                    {

                        if(data.success) {

                            data = data.data;
                            let allowedInputFields = [
                                'title', 'imdb_id', 'tmdb_id', 'total_seasons', 'total_episodes', 'poster_url',
                                'banner_url', 'country', 'released_at', 'language', 'imdb_rate'
                            ];

                            appendInputData(data,  allowedInputFields );

                            let ff = 'option[value="'+data.status+'"]';
                            $(ff).prop('selected', true);

                            $('.poster-wrap').html( '<img src="' + data.poster_url + '" class="w-100 mb-2" alt="poster-image">' );
                            $('.banner-wrap').html( '<img src="' +  data.banner_url + '" class="w-100 mb-2" alt="banner-image">' );

                            update_genres( data.genres );
                            update_translations( data.translations );

                        }else{

                            alert( data.error );

                        }



                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    },
                    complete: function ()
                    {
                        btn_loaded( $this );
                    }
                });
            }else{
                let msg = $('.autoload-msg').text();
                alert( msg );
            }

        });
        $("#load-episode-data").on('click', function () {

            let data = null;

            let imdbId = $.trim( $('input[name="imdb_id"]').val() );
            let seriesId = $.trim( $('select[name="series_id"]').val() );
            let season = $.trim( $('input[name="season"]').val() );
            let episode = $.trim( $('input[name="episode"]').val() );

            let $this = $(this);

            if(  seriesId  && season && episode ) {
                data = {
                    'series_id' : seriesId,
                    'season' : season,
                    'episode' : episode
                }
            }else if( imdbId ) {
                data = {
                    'imdb_id' : imdbId
                };
            }


            if(data !== null) {

                //attempt to load data
                $.ajax({
                    url : BASE_URL + '/ajax/autoload/load_episode_data',
                    type: "GET",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: data,
                    dataType: "JSON",
                    beforeSend: function() {
                        btn_loading( $this );
                    },
                    success: function(data)
                    {


                        if(data.success) {

                            data = data.data;

                            let allowedInputFields = [
                                'title', 'imdb_id', 'tmdb_id', 'imdb_rate', 'duration', "season",
                                'episode', 'banner_url', 'released_at', 'trailer'
                            ];

                            for (let index = 0; index < allowedInputFields.length; ++index) {
                                let field = allowedInputFields[index];
                                let selector = 'input[name="'+ field +'"]';
                                $(selector).val( data[field] );
                            }

                            $('textarea[name="description"]').text( data.description );
                            $('.banner-wrap').html( '<img src="' +  data.banner_url + '" class="w-100 mb-2" alt="banner-image">' );

                            update_translations(data.translations);

                        }else{

                            alert( data.error );

                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    },
                    complete: function() {
                        btn_loaded( $this );
                    },
                });

            }else{
                let msg = $('.autoload-msg').text();
                alert( msg );
            }






        });
        $("#load-movie-data").on('click', function () {

            let $this = $(this);

            let loadId = null;

            let imdb_id = $.trim( $('input[name="imdb_id"]').val() );
            let tmdb_id = $.trim( $('input[name="tmdb_id"]').val() );

            if(imdb_id) loadId = imdb_id;
            if(! imdb_id && tmdb_id) loadId = tmdb_id;

            if(loadId !== null){
                $.ajax({
                    url : BASE_URL + '/ajax/autoload/load_movie_data',
                    type: "GET",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        'id' : loadId
                    },
                    dataType: "JSON",
                    beforeSend: function ()
                    {
                        btn_loading( $this );
                    },
                    success: function(data)
                    {

                        if(data.success) {

                            data = data.data;
                            let allowedInputFields= [
                                'title', 'imdb_id', 'tmdb_id', 'imdb_rate', 'duration', 'language',
                                'released_at', 'trailer', 'poster_url', 'banner_url', 'country'
                            ];

                            for (let index = 0; index < allowedInputFields.length; ++index) {
                                let field = allowedInputFields[index];
                                let selector = 'input[name="'+ field +'"]';
                                $(selector).val( data[field] );
                            }

                            $('textarea[name="description"]').text( data.description );

                            $('.poster-wrap').html( '<img src="' + data.poster_url + '" class="w-100 mb-2" alt="poster-image">' );
                            $('.banner-wrap').html( '<img src="' +  data.banner_url + '" class="w-100 mb-2" alt="banner-image">' );

                            update_genres(data.genres);
                            update_translations(data.translations);

                        }else{

                            alert( data.error );

                        }



                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    },
                    complete: function ()
                    {
                        btn_loaded( $this );
                    }
                });
            }else{
                let msg = $('.autoload-msg').text();
                alert( msg );
            }

        });

        function update_translations( translations )
        {

            if(translations !== null && translations.length > 0){

                translations.forEach(function (item, index) {

                    let titleSelector = '[name="translations['+ item['lang'] +'][title]"]';
                    let descSelector = '[name="translations['+ item['lang'] +'][description]"]';

                    if($(titleSelector).length > 0){

                        $(titleSelector).val( item['title'] );
                        $(descSelector).val( item['description'] );

                    }

                });

            }
        }

    }

    function init_discover()
    {
        let type = 'movies';
        let results = $("#results");
        let QueriedData = null;
        let loadbtn = null;
        let itemsSelectionPanel = $('#items-selected-panel');
        let selected = [];
        let totalPages = 0;

        $("#init-discover").on('click', function (){

            loadbtn = $(this);
            type = $(this).attr('data-type');

            //clear results
            results.html('');

            QueriedData = null;

            //discover
            discover();
        });

        $(".load-next-page").on('click',  function (){
            loadbtn = $(this);
            //discover
            discover();
        });

        $(".reset-selected-items").on('click', function (){
            selected = [];
            itemsSelectionPanel.hide();
            itemsSelectionPanel.find('.items-selected').text( 0 );
            $('.movie-item.new').removeClass('selected');
        });

        $(document).on('click', '.discover .select-all', function (){
            if($(this).attr('data-type') === 'select'){
                $(this).closest('.x_panel').find('.movie-item.new .cover:not(.movie-item.new.selected .cover)').trigger('click');
                $(this).attr('data-type', 'deselect');
            }else{
                $(this).closest('.x_panel').find('.movie-item.new .cover').trigger('click');
                $(this).attr('data-type', 'select');
            }

        });
        $(document).on('click', '.discover .movie-item.new .cover', function (){
            let movieItem = $(this).closest('.movie-item');
            movieItem.toggleClass('selected');

            let tmdb = movieItem.attr('data-tmdb');

            if(! movieItem.hasClass('selected')){
                let index = selected.indexOf( tmdb );
                if (index !== -1) {
                    selected.splice(index, 1);
                }
            }else{
              selected.push( tmdb );
            }

            if(selected.length > 0){
                itemsSelectionPanel.show();
                itemsSelectionPanel.find('.items-selected').text( selected.length );
                $('[name="ids"]').val( selected.join(',') );
            }else{
                itemsSelectionPanel.hide();
                itemsSelectionPanel.find('.items-selected').text( 0 );
                $('[name="ids"]').val('');
            }
        });


        function discover()
        {
            $.ajax({
                url : BASE_URL + '/ajax/discover',
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest'},
                data: getQueries(),
                dataType: "JSON",
                async: false,
                beforeSend: function ()
                {
                    btn_loading( loadbtn );
                },
                success: function( data )
                {

                    if(data.success) {
                        let innerData = data['data'];

                        updateResults( innerData.results );
                        updatePages( innerData.page, innerData.total_pages );

                    }else{



                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error occurred');
                },
                complete: function ()
                {
                    let page = QueriedData.page - 1;

                    setTimeout(function (){
                        let panel_id = "#" + 'x_panel_' + page;
                        $(panel_id).show();
                        $('.next-page-btn-wrap').show();
                        btn_loaded( loadbtn );
                    }, 1500);
                }
            });
        }

        function getQueries()
        {
            if(QueriedData === null){
                let year = $('[name="year"]').val();
                let page = parseInt( $('[name="page"]').val() );
                let sort = $('[name="sort"]').val();
                let sort_dir = $('[name="sort_dir"]').val();
                let lang = $('[name="lang"]').val();
                let imported_filter = $('[name="imported_filter"]:checked').val();
                let genres = [];
                let status = '';
                let showType = '';

                if(type !== 'movies'){
                    status = $('[name="status"]').val();
                    showType = $('[name="type"]').val();
                }

                $("input:checkbox[name=\"genre\"]:checked").each(function(){
                    genres.push($(this).val());
                });

                genres = genres.join(',');

                QueriedData =  {
                    year: year,
                    status: status,
                    show_type: showType,
                    genres: genres,
                    lang: lang,
                    sort: sort,
                    sort_dir: sort_dir,
                    imported_filter: imported_filter,
                    page: page,
                    type: type
                }


            }

            return QueriedData;

        }

        function updateResults( results )
        {
            $("#results").append( results );
        }

        function updatePages(page, total_pages = 0)
        {
            $('[name="page"]').val(page);

            $('.total-pages').text( total_pages );
            $('.total-pages').closest('.input-group-append').show();

            totalPages = total_pages;

            if(! isFinished()){
                QueriedData.page += 1;
            }else{
                $('.load-next-page').hide();
            }
        }

        function isFinished()
        {
            return totalPages <= QueriedData.page;
        }


    }

    function init_tv_shows_selection()
    {
        $("#select-tv-show").on('change', function (){

            let seriesId = this.value;

            if(seriesId) {

                $.ajax({
                    url : BASE_URL + '/ajax/autoload/load_next_episode',
                    type: "GET",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        'series_id' : seriesId
                    },
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success close modal and reload ajax table
                        if(data.success) {
                            let episodeData = data.data;
                            $('input[name="season"]').val( episodeData.nextSeason );
                            $('input[name="episode"]').val( episodeData.nextEpisode );
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    }
                });

            }


        });
    }

    function init_suggestion()
    {
        let search_thread = null;
        let term = '';
        let type = 'movie';
        let resultsContent = $("#suggest-results");

        $('.title-suggest').on('keyup', function (){

            if($('input[name="season"]').length === 0){

                let $this = $(this);
                type = $this.attr('data-type');

                clearTimeout( search_thread );
                cleanResults();

                search_thread = setTimeout(function(){
                    term = $this.val().trim();
                    if(term.length > 0){
                        load_results();
                    }
                }, 500);

            }
        });

        $(document).on('click', '#suggest-results .movie-item.new', function (){

            let tmdbId = $(this).attr('data-tmdb');
            $('input[name="tmdb_id"]').val( tmdbId );

            //clean results
            cleanResults();

            //run autoload
            if(type === 'movie'){
                $("#load-movie-data").click();
            }else if(type === 'tv'){
                $("#load-tv-data").click();
            }

        });

        function load_results()
        {
            $.ajax({
                url : BASE_URL + '/ajax/suggest',
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest'},
                data: {
                    'title' : term,
                    'type'  : type
                },
                dataType: "JSON",
                beforeSend: function () {

                    // self.loading();

                },
                success: function( data )
                {

                    if(data.success){
                        let results = data.data.results;
                        addResults( results );
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error occurred');
                },
                complete: function () {
                    // self.loaded();
                }
            });
        }

        function addResults( results )
        {
            resultsContent.html( results );
        }

        function cleanResults()
        {
            resultsContent.html('');
        }

    }

    function btn_loading( btn )
    {
        if(btn instanceof jQuery) {
            if(btn.find('.spinner-border').length > 0) {
                btn.find('i.fa').hide();
                btn.attr('disabled', 'disabled');
                btn.find('.spinner-border').show();
            }
        }
    }

    function appendInputData( data, allowedInputFields )
    {
        for (let index = 0; index < allowedInputFields.length; ++index) {
            let field = allowedInputFields[index];
            let selector = 'input[name="'+ field +'"]';
            $(selector).val( data[field] );
        }
    }

    function btn_loaded( btn )
    {
        if(btn instanceof jQuery) {
            if(btn.find('.spinner-border').length > 0) {
                btn.find('i.fa').show();
                btn.removeAttr('disabled');
                btn.find('.spinner-border').hide();
            }
        }
    }

    function update_genres(genres)
    {

        if(genres.length > 0){
            let selectedGenres = [];
            console.log(genres);
            genres.forEach(function (item, index) {
                let genre = item.toLowerCase();

                let val = $('select[name="genres[]"] option').filter(function () { return $(this).html() == genre; }).val();
                console.log(selectedGenres);
                if(val) {
                    selectedGenres.push(val);
                }
            });
            $('#select-genres').val(selectedGenres);
            $('#select-genres').trigger('change');
        }
    }


    function init_data_list_datatable()
    {

        if (typeof ($.fn.DataTable) === 'undefined') { return; }
        let filterByLinks = $('select[name="filter_movie_results_by_links"]').val();
        let filterByLinksType = $('select[name="filter_links_results_by_type"]').val();


        $('#datatable').DataTable({
            order: [],
            pageLength: 25,
            responsive: true
        });


        $('#movies-list-datatable').DataTable( {
            dom: '<"datatable-top-btn-list"B><"float-left"l><"float-right"f>rtip',
            buttons: [
                'colvis',
                {
                    extend: 'collection',
                    text: 'Export data',
                    buttons: [
                        {
                            extend: "csv",
                            className: "btn-sm",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn-sm",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                    ]
                },
                {
                    extend: "print",
                    className: "btn-sm",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    text:  ' <i class="fa fa-trash"></i>&nbsp; Delete Selected Items - <span class="num-of-selected-items"> 0 </span>',
                    attr: {
                        id: 'del-dt-movies-selected-items',
                        class: 'btn btn-sm btn-danger',
                        style: 'display: none'
                    },
                    action: function ( e, dt, node, config ) {
                        del_all_selected_movies( dt );
                    }
                }
            ],
            responsive: true,
            // stateSave: true,
            columnDefs: [ {
                targets: [6,7,10],
                visible: false
            },{
                targets: 0,
                checkboxes: {
                    selectRow: true
                }
            } ],
            order: [
                [1, 'desc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: BASE_URL + '/'+ $("#movies-list-datatable").attr('data-type') +'/load_json_data',
                type: 'POST',
                data: {
                    filter: filterByLinks
                },
                dataSrc: function(data){
                    $(".page-title h3").text( data.page_title );

                    // Datatable data
                    return data.aaData;
                }
            },
            columns: [
                { data: 'selection' },
                { data: 'id' },
                { data: 'poster' },
                { data: 'title' },
                { data: 'imdb_id' },
                { data: 'tmdb_id' },
                { data: 'year' },
                { data: 'imdb_rate' },
                { data: 'views' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'actions' },
            ]
        } ).on('change', 'input[type="checkbox"]', function (){

            let selectedItems = $('.dt-checkboxes:checked').length;
            let allDelBtn = $("#del-dt-movies-selected-items");
            allDelBtn.find(".num-of-selected-items").text( selectedItems );

            if($("input[type=\"checkbox\"]:checked").length){
                allDelBtn.show();
            }else{
                allDelBtn.hide();
            }

        });


        $('#links-list-datatable').DataTable( {
            dom: '<"datatable-top-btn-list"B><"float-left"l><"float-right"f>rtip',
            buttons: [
                {
                    extend: 'collection',
                    text: 'Export data',
                    buttons: [
                        {
                            extend: "csv",
                            className: "btn-sm",
                            exportOptions: {
                                columns: [0,1,2,3,4]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn-sm",
                            exportOptions: {
                                columns: [0,1,2,3,4]
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm",
                            exportOptions: {
                                columns: [0,1,2,3,4]
                            }
                        },
                    ]
                },
                {
                    extend: "print",
                    className: "btn-sm",
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                },

                {
                    text:  ' <i class="fa fa-trash"></i>&nbsp; Delete Selected Items - <span class="num-of-selected-items"> 0 </span>',
                    attr: {
                        id: 'del-dt-links-selected-items',
                        class: 'btn btn-sm btn-danger',
                        style: 'display: none'
                    },
                    action: function ( e, dt, node, config ) {
                        del_all_selected_links( dt );
                    }
                }
            ],
            responsive: true,
            pageLength: 25,
            columnDefs: [ {
                targets: 0,
                checkboxes: {
                    selectRow: true
                }
            } ],
            order: [
                [1, 'desc']
            ],
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: BASE_URL + '/links/load_json_data?filter=' + filterByLinksType,
                type: 'POST',
                dataSrc: function(data){
                    $(".page-title h3").text( data.page_title );

                    // Datatable data
                    return data.aaData;
                }
            },
            columns: [
                { data: 'selection' },
                { data: 'id' },
                { data: 'link' },
                { data: 'requests' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'actions' },
            ]
        } ).on('change', 'input[type="checkbox"]', function (){

            let selectedItems = $('.dt-checkboxes:checked').length;
            let allDelBtn = $("#del-dt-links-selected-items");
            allDelBtn.find(".num-of-selected-items").text( selectedItems );

            if($("input[type=\"checkbox\"]:checked").length){
                allDelBtn.show();
            }else{
                allDelBtn.hide();
            }

        });

        $('#users-added-links-list-datatable').DataTable( {
            dom: '<"datatable-top-btn-list"B><"float-left"l><"float-right"f>rtip',
            responsive: true,
            pageLength: 25,
            columnDefs: [ {
                targets: 0
            }, { className: "text-left", "targets": [ 1 ] } ],
            order: [
                [1, 'desc']
            ],
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: BASE_URL + '/links/users-added/load_json_data',
                data: {
                    type: typeof LINKS_TYPE !== 'undefined' ? LINKS_TYPE : '',
                    movie_type: typeof LINKS_MOVIE_TYPE !== 'undefined' ? LINKS_MOVIE_TYPE : '',
                    status: filterByLinksType,
                    user: typeof LINKS_USER_ID !== 'undefined' ? LINKS_USER_ID : ''
                },
                type: 'GET',
                dataSrc: function(data){
                    $(".page-title h3").html( data.page_title );

                    // Datatable data
                    return data.aaData;
                }
            },
            columns: [
                { data: 'id' },
                { data: 'link' },
                { data: 'user' },
                { data: 'status' },
                { data: 'created_at' },
                { data: 'actions' },
            ]
        } );

        $('#series-list-datatable').DataTable( {
            dom: '<"datatable-top-btn-list"B><"float-left"l><"float-right"f>rtip',
            buttons: [
                'colvis',
                {
                    extend: 'collection',
                    text: 'Export data',
                    buttons: [
                        {
                            extend: "csv",
                            className: "btn-sm",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn-sm",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm",
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                    ]
                },
                {
                    extend: "print",
                    className: "btn-sm",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    text:  ' <i class="fa fa-trash"></i>&nbsp; Delete Selected Items - <span class="num-of-selected-items"> 0 </span>',
                    attr: {
                        id: 'del-dt-series-selected-items',
                        class: 'btn btn-sm btn-danger',
                        style: 'display: none'
                    },
                    action: function ( e, dt, node, config ) {
                        del_all_selected_series( dt );
                    }
                }
            ],
            responsive: true,
            columnDefs: [ {
                targets: [6,7,8,10, 11],
                visible: false
            },{
                targets: 0,
                checkboxes: {
                    selectRow: true
                }
            }, {
                orderable: false, targets: [13]
            }, {
                className: "text-left", targets: [3]
            } ],
            order: [
                [1, 'desc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: BASE_URL + '/series/load_json_data',
                type: 'POST',
                dataSrc: function(data){
                    $(".page-title h3").text( data.page_title );

                    // Datatable data
                    return data.aaData;
                }
            },
            columns: [
                { data: 'selection' },
                { data: 'id' },
                { data: 'poster' },
                { data: 'title' },
                { data: 'imdb_id' },
                { data: 'tmdb_id' },
                { data: 'year' },
                { data: 'total_seasons' },
                { data: 'total_episodes' },
                { data: 'is_completed' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'status' },
                { data: 'actions' }
            ]
        } ).on('change', 'input[type="checkbox"]', function (){

            let selectedItems = $('.dt-checkboxes:checked').length;
            let allDelBtn = $("#del-dt-series-selected-items");
            allDelBtn.find(".num-of-selected-items").text( selectedItems );

            if($("input[type=\"checkbox\"]:checked").length){
                allDelBtn.show();
            }else{
                allDelBtn.hide();
            }

        });

        let filter = $(".ve-results--filter").clone();
        filter.removeClass('d-none');

        $(".datatable-top-btn-list").append( filter );



        function del_all_selected_movies( dt )
        {
            if(! IS_ADMIN){
                alert('Access Denied');
                return;
            }

            let selectedItems = getSelectedItemsId( dt );
            if(selectedItems.length > 0){

                $.ajax({
                    url : BASE_URL + '/movies/bulk_delete',
                    type: "POST",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        'ids' : selectedItems
                    },
                    dataType: "JSON",
                    success: function(data)
                    {

                        if(data.success) {

                            alert('Selected movies has been deleted successfully');
                            window.location.reload();

                        }else{

                            alert('Unable to delete');

                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    }
                });

            }

        }

        function del_all_selected_links( dt )
        {
            if(! IS_ADMIN){
                alert('Access Denied');
                return;
            }

            let selectedItems = getSelectedItemsId( dt );
            if(selectedItems.length > 0){

                $.ajax({
                    url : BASE_URL + '/links/bulk_delete',
                    type: "POST",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        'ids' : selectedItems
                    },
                    dataType: "JSON",
                    success: function(data)
                    {

                        if(data.success) {

                            alert('Selected links has been deleted successfully');
                            window.location.reload();

                        }else{

                            alert('Unable to delete');

                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    }
                });

            }

        }

        function del_all_selected_series( dt )
        {
            if(! IS_ADMIN){
                alert('Access Denied');
                return;
            }

            let selectedItems = getSelectedItemsId( dt );
            if(selectedItems.length > 0){

                $.ajax({
                    url : BASE_URL + '/series/bulk_delete',
                    type: "POST",
                    headers: { 'X-Requested-With': 'XMLHttpRequest'},
                    data: {
                        'ids' : selectedItems
                    },
                    dataType: "JSON",
                    success: function(data)
                    {

                        if(data.success) {

                            alert('Selected series has been deleted successfully');
                            window.location.reload();

                        }else{

                            alert('Unable to delete');

                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error occurred');
                    }
                });

            }

        }

        function getSelectedItemsId( dt )
        {
            let selectedItems = [];
            $('.dt-checkboxes:checked').each(function (i, item) {
                let tr = $(item).closest('tr');
                let row = dt.rows(tr).data();
                selectedItems.push( row[0]['id'] );
            });

            return selectedItems;
        }
    }


    function importMovie( movie_uniq_id )
    {
        $.ajax({
            url : BASE_URL + '/ajax/import',
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest'},
            data: {
                'imdb_id' : movie_uniq_id
            },
            dataType: "JSON",
            success: function(data)
            {

                if(data.success) {



                }

            },
            complete: function () {

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error occurred');
            }
        });
    }





})(jQuery);


function filter_movie_results(value) {
    let url = location.protocol + '//' + location.host + location.pathname;
    window.location.href = url + '?filter=' + value;
}

function users_added_links_custom_filter(status, movieType)
{
    if(status === null){
        status = typeof LINKS_STATUS !== 'undefined' ? LINKS_STATUS : '';
        if(status === null) status = '';
    }
    if(movieType === null){
        movieType = typeof LINKS_MOVIE_TYPE !== 'undefined' ? LINKS_MOVIE_TYPE : '';
        if(movieType === null) movieType = '';
    }

    let userId = typeof LINKS_USER_ID != 'undefined' ? LINKS_USER_ID : '';

    let url = location.protocol + '//' + location.host + location.pathname;
    url += '?status=' + status + '&movie_type=' + movieType;
    if(userId !== ''){
        url += '&user=' + userId;
    }
    window.location.href = url;
}


function users_added_links_type_change(value, userId) {
    let url = BASE_URL + '/users/links/' + value + '?user=' + userId;
    window.location.href = url;
}

function get_short_embed_link( movieId )
{
    return SITE_URL + EMBED_SLUG + '/' + movieId;
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function confirmLicense()
{
    let license = $('#license').val();

    if(license.length > 0){

        $.ajax({
            url : BASE_URL + '/settings/license/check',
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest'},
            data: {
                'key': license
            },
            dataType: "JSON",
            success: function(data)
            {
                if(data.success){
                    alert('Your license has already been activated by Jhonn!.');
                }else{
                    alert('Congratulations ! License confirmed by Jhonn!.');
                }
            },
            complete: function () {
                setTimeout(function (){
                    window.location.reload();
                }, 1500);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

            }
        });

    }


}


function stars_log_status_changed(elmt, userId){

    let val = $(elmt).val();
    window.location.href = BASE_URL + '/stars-log?user=' + userId + '&status=' + val;

}