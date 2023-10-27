let chart_data = {};
let visitorsMap = $('#map-visitors-by-countries');
if( visitorsMap.length === 1){
        visitorsMap.vectorMap({
                map: 'world_en',
                backgroundColor: 'transparent',
                color: '#ffffff',
                hoverOpacity: 0.7,

                enableZoom: true,
                showTooltip: true,

                normalizeFunction: 'polynomial',
                values: ( chart_data ),
                onLabelShow: function (event, label, code) {
                        if (chart_data[code] > 0) {
                                label.append(': <strong>' + chart_data[code] + '</strong>');
                        }
                },
        });
}
