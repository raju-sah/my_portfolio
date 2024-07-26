<div id="visitorMap" class="w-50" style=" height: 350px"></div>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script>
    am4core.ready(function() {
        // Create map instance and set defaults
        var chart = am4core.create("visitorMap", am4maps.MapChart);
        chart.geodata = am4geodata_worldLow;
        chart.projection = new am4maps.projections.Miller();

        // Create map polygon series and exclude Antarctica
        var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
        polygonSeries.exclude = ["AQ"]; // Exclude Antarctica
        polygonSeries.useGeodata = true;
        polygonSeries.calculateVisualCenter = true;

        const cityData = @json($countryCityList);

        const countryDataMap = cityData.reduce((map, city) => {
            if (!map[city.country]) {
                map[city.country] = {
                    activeUsers: 0,
                    screenPageViews: 0,
                    cities: [],
                };
            }
            map[city.country].activeUsers += city.activeUsers;
            map[city.country].screenPageViews += city.screenPageViews;
            map[city.country].cities.push(city);
            return map;
        }, {});

        const mapData = Object.entries(countryDataMap).map(([country, data]) => {
            const cityInfo = data.cities.map(city =>
                `${city.city}: ${city.activeUsers},views:${city.screenPageViews}`).join("\n");

            return {
                id: am4geodata_worldLow.features.find(f => f.properties.name === country)?.id,
                totalVisitorCount: data.activeUsers,
                cityInfo: cityInfo || "No data available",
                views: data.screenPageViews,
                fill: am4core.color("#F05C5C"),
            };
        }).filter(data => data.id);

        // Configure polygon template
        polygonSeries.data = mapData;
        var polygonTemplate = polygonSeries.mapPolygons.template;
        polygonTemplate.propertyFields.fill = "fill";
        polygonTemplate.tooltipText = "{name}: {totalVisitorCount},views:{views}\n(\n{cityInfo}\n)";
        polygonTemplate.fill = am4core.color("#ccc");
    });
</script>
