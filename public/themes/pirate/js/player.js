
"use strict";

const GCaptcha = {
    token: null,
    isEnabled: function (){
        return typeof grecaptcha !== 'undefined';
    },
    reload: function () {
        grecaptcha.reset();
        grecaptcha.execute();
    },
    getToken: function (){
        return this.token;
    },
    setToken: function ( token ){
        this.token = token;
    }
}

const Player = {

    id: null,
    name: 'VIP Embed Player',
    version: '2.0',
    author: 'John Antonio',
    isInit: false,
    isPlayed: false,
    linkToken: null,
    playedToken: null,
    node: null,

    servers: {

        activeId: null,
        node: null,
        group: null,

        init: function (){
            let self = this;

            //init servers node
            self.group = "#" + $('.active-server-group .name').text() + '-servers';
            self.node = $( self.group );

        },
        update: function ( server ){
            let self = this;

            let id = server.attr('data-id');
            self.activeId = id;

            let selector = '.server[data-id="'+ id +'"]';
            let activeServer = self.node.find(selector).text().trim();

            self.node.find('.active-server .name').text( activeServer );

            //close servers dropdown list
            halfmoon.deactivateAllDropdownToggles();
        },
        get: function (){
            let self = this;

            if(self.activeId === null){
                self.activeId = self.node.find('.server').first().attr('data-id');
            }
            return self.activeId;
        }

    },
    init: function () {
        let self = this;

        if( self.isInit ){
            return;
        }

        //set author credits
        self.setAuthorCredit();

        //set player node
        self.node = $("#embed-player");

        //init servers
        self.servers.init();

        //set player id
        self.setPlayerId();

        self.isInit = true;
    },
    play: function (isVerified = false, server = null) {
        let self = this;

        //player loading
        self.loading();


        //attempt to get link
        if(server !== null){
            self.servers.update( $(server) );
        }

        //check captcha
        if(GCaptcha.isEnabled()){
            if(! isVerified){
                GCaptcha.reload();
                return;
            }
        }

        //attempt to get link
        let link = self.getLink();


        //check link
        if(link !== null){

            /*
                set link to frame
                ( we does not close loader in here, it will
                will close automatically after content loaded )
             */
            self.loadFrame( link );

            if(! self.isPlayed){
                setTimeout(function (){
                    self.played();
                }, 10000);
            }

        }else{

            //stop loader animation
            self.loaded();
        }


        //player loaded link in first time
        if(! self.isPlayed){
            self.isPlayed = true;
        }

    },
    changeGroup: function ( group ) {

        let groupId = "#" + $(group).attr('data-id') + '-servers';
        if($(groupId).length > 0){
            $('.servers').hide();
            this.servers.node = $(groupId);
            $(groupId).find('.server').first().click();
            $(groupId).show();
        }
    },
    getLink: function (){
        let self = this;

        let link = null;

        $.ajax({

            url : BASE_URL + 'ajax/get_stream_link',
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest'},
            data: {
                'id'       : self.servers.get(),
                'movie'    : self.id,
                'is_init'  : self.isPlayed,
                'captcha'  : GCaptcha.getToken(),
                'ref'      : self.getRef()
            },
            dataType: "JSON",
            async: false,

            success: function(data)
            {

                if(data.success) {

                    link = data.data.link;
                    self.linkToken = data.data.token;
                    if(! self.isPlayed){
                        self.playedToken = data.data._played;
                    }

                }else{
                    if('error' in data){
                        self.errorOccurred(data.error);
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                setTimeout(function (){
                    self.errorOccurred(errorThrown);
                }, 1000);

            }
        });

        return link;
    },
    played: function (){

        let self = this;

        $.ajax({
            url : BASE_URL + 'ajax/played',
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest'},
            data: {
                'token'      : self.playedToken,
            },
            dataType: "JSON",
        });

    },
    loading: function (){
        let self = this;
        self.node.find('.cover, .play-btn, .frame, .error').hide();
        self.node.find('.loader').css('display', 'flex');
    },
    loaded: function ( ) {
        let self = this;

        setTimeout(function (){
            //close loader
            self.node.find('.loader').fadeOut(1500);
            self.node.find('.frame').fadeIn(100);
        }, 1500);

    },
    loadFrame: function ( link ) {
        let self = this;
        self.node.find('iframe').prop('src', link);
    },
    setPlayerId: function () {
        let self = this;

        if(self.id === null) {
            self.id = self.node.attr('data-movie-id');
        }

    },
    setAuthorCredit: function (){
        console.clear();
        console.log(
            "%c! " + this.name,
            "color:#1b59a3;font-family:system-ui;font-size:1rem;font-weight:bold"
        );
        console.log('Version - ' + this.version);
        console.log('Nulled by - HauN');
    },
    getRef: function () {
        let result = '',
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === 'ref') result = decodeURIComponent(tmp[1]);
            });
        return result;
    },
    errorOccurred: function ( error ) {
        let self = this;

        self.node.find('.error .msg').text( error );
        self.node.find('.error').css('display', 'flex');
    },
    bind: function(selector, action, event = 'click'){
        $(document).on(event,selector,function(self) {
            return function (e){
                return self[action].apply(self, arguments);
            }
        }(this));
    }
}

$(document).ready(function() {

    //init player
    Player.init();

    window.set_captcha_response = function( response ){

        //set token and play
        GCaptcha.setToken( response );
        Player.play( true );

    };

    // ========================== show/hide top bar ( embed meta info ) ==========================
    $(".toggle-top-bar").on('click', function (){

        $("#embed-player .top-bar").toggle();
        $("#embed-player .toggle-btn-short").toggle();

    });

    // ========================== waiting till once iframe is done loading ==========================
    $('#embed-player iframe').on('load', function(){

        if($(this).attr('src') !== undefined){
            Player.loaded();
        }

    });

    $("#report-st-link").on('click', function (){

        if(Player.linkToken !== null){

            let formData = $(this).closest('form').serialize();
            formData += '&token=' + Player.linkToken;

            $.ajax({

                url : BASE_URL + 'ajax/report_stream_link',
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest'},
                data: formData,
                dataType: "JSON",
                async: false,

                success: function(data)
                {

                    if(data.success) {

                        alert('reported', 'alert-success');

                    }else{
                        if('error' in data){
                            alert(data.error, 'alert-danger');
                        }
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    setTimeout(function (){
                        alert(errorThrown, 'alert-danger');
                    }, 1000);

                }
            });

        }else{
            halfmoon.initStickyAlert({
                title: 'Try to play video',
                alertType: 'alert-secondary',
                hasDismissButton: false,
                timeShown: 1500
            });
            //close servers dropdown list
            halfmoon.deactivateAllDropdownToggles();
        }

    });


    if(AUTOPLAY) {
        Player.play();
    }
})