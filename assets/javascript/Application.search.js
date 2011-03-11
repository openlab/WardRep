Application.search = function() {
    this.initDocLocation();
    
    this.map_instance = new VEMap("bing-maps");
    this.map_instance.LoadMap();
    this.map_instance.SetMapMode(VEMapMode.Mode2D);
    
    this.setSearchedLocationAndZoom();
    this.drawWardBoundaries();
    
    this.map_instance.AttachEvent("onclick", (function f(o) {
        return function(e) {
            o.mapOnClickCallback(e, o);
        };
    })(this));
    
    $(this.navtabs_elid + " li a").bind('click', (function(o) {
        return function() {
            o.tabSwitch($(this));
        };
    })(this));
};

Application.search.prototype = {
    map_instance : null,
    doc_location : null,
    
    navtabs_elid : "#nav-tabs",
    
    initDocLocation : function() {
        var hash = document.location.hash;
        var hash = hash.replace('#', '');
        if( hash )
        {
            this.highlightWardRep(hash);
        }
    },
    
    setSearchedLocationAndZoom : function() {
        if( Application.config.search.searched_location )
        {
            try {
                var searchedAddrPinIcon = new VECustomIconSpecification();
                searchedAddrPinIcon.Image = Application.config.search.searched_location.pushpin;
                
                var latlng = new VELatLong(
                    Application.config.search.searched_location.geocode.latitude,
                    Application.config.search.searched_location.geocode.longitude
                );
                
                var pin = new VEShape(VEShapeType.Pushpin, latlng);
                pin.SetCustomIcon(searchedAddrPinIcon);
                pin.Show();
                
                this.map_instance.AddShape(pin);
                this.map_instance.SetCenterAndZoom(latlng, 12);
            }
            catch( exception )
            {
                /* void */
            }
        }
    },
    
    drawWardBoundaries : function() {
        if( Application.config.search.wards )
        {
            var colorOffset = 0; var colorMaxOffset = Application.config.search.polygon_bg_colors.length - 1;
            for( i = 0; i != Application.config.search.wards.count; ++i )
            {
                var coords = Application.config.search.wards.data[i].kmlcoords.split("|");
                var points = [];
                
                for( var k in coords )
                {
                    coords[k] = coords[k].split(",");
                    points.push(new VELatLong(parseFloat(coords[k][1]), parseFloat(coords[k][0])));
                }
                
                try {
                    var poly = new VEShape(VEShapeType.Polygon, points);
                    var color = Application.config.search.polygon_bg_colors[colorOffset];
                    
                    poly.SetLineWidth(2);
                    poly.SetLineColor(this.createVEColorWithHex(color, 1.0));
                    poly.SetFillColor(this.createVEColorWithHex(color, 0.5));
                    
                    var wardid = parseInt(Application.config.search.wards.data[i].wardnumber);
                    poly.SetWardID(wardid);
                    
                    poly.SetCustomIcon('<div class="polygon-label"><span style="opacity: 1;">WARD ' + wardid + '</span></div>');
                    
                    this.map_instance.AddShape(poly);
                }
                catch( exception )
                {
                    /* something interesting ... */
                }
                
                if( colorOffset == colorMaxOffset )
                {
                    colorOffset = 0;
                }
                else
                {
                    ++colorOffset;
                }
            }
        }
    },
    
    createVEColorWithHex : function(color, alpha) {
        var r = parseInt( color.substring(0, 2), 16 );
        var g = parseInt( color.substring(2, 4), 16 );
        var b = parseInt( color.substring(4, 6), 16 );
        
        return new VEColor(r, g, b, alpha);
    },
    
    mapOnClickCallback : function(event, instance) {
        if( event.elementID != null )
        {
            var poly = instance.map_instance.GetShapeByID(event.elementID);
            var wardId = poly.GetWardID();
            
            if( null != wardId )
            {
                var wardElId = 'ward-' + wardId;
                instance.highlightWardRep(wardElId);
                
                document.location.hash = '#' + wardElId;
                // document.location = document.location + (wardElId);
            }
        }
    },
    
    highlightWardRep : function(wardElId) {
        $("#view-all-details .details div").each(function() {
            if( $(this).hasClass('highlight') )
                $(this).removeClass('highlight');
            
            var id = $(this).attr('id');
            if( wardElId == id )
                $(this).addClass('highlight');
        });
    },
    
    tabSwitch : function(tab) {
        $(this.navtabs_elid + " li a").each(function() {
            var detailsId = $(this).attr('id');
            detailsId = "#" + detailsId + "-details";
            
            if( tab.attr('id') == $(this).attr('id') ) {
                $(this).parent().addClass('active');
                $(detailsId).removeClass('display-none');
            } else {
                $(this).parent().removeClass('active');
                $(detailsId).addClass('display-none');
            }
        });
    }
};

Application.behaviors.search = function(context) {
    if( !Application.search )
        return;
    
    var search = new Application.search();
};