<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-title">Grafik </div>
            <hr>
            <div class="panel-body">
                <canvas id="chart-bars" style=" width: 100%"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row" hidden>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h1 class="panel-title">Maps</h1>
            </div>
            <div class="panel-body">
                <div id="g_maps" style="height: 370px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var ctx = document.getElementById("chart-bars");
    ctx.height = 70;
    pxInit.push(function() {
        $(function() {
            var colors = [
                '#2cadd4',
                '#72b159'
            ];

            var data = {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember'],
                datasets: [{
                    label:           'Data',
                    data:            [<?php echo implode(',',$sppd_chart); ?>],
                    borderWidth:     1,
                    backgroundColor: pxUtil.hexToRgba(colors[0], 1),
                    borderColor:     colors[0],
                }, {
                    label:           'Data 2',
                    data:            [<?php echo implode(',',$spj_chart); ?>],
                    borderWidth:     1,
                    backgroundColor: pxUtil.hexToRgba(colors[1], 1),
                    borderColor:     colors[1],
                }],
            };

            new Chart(document.getElementById('chart-bars').getContext("2d"), {
                type: 'bar',
                data: data,
            });
        });
    });
</script>

<script>

    var map;

    function initMap() {
        map = new google.maps.Map(document.getElementById('g_maps'), {
            zoom: 5,
            center: new google.maps.LatLng(-2.3, 115.9213),
            mapTypeId: 'terrain'
        });


    }

    pxInit.push(function () {

        $.getJSON('<?php echo base_url('api/surat') . '?tahun=2018&tipe=surat_masuk' ?>', function (data) {
            // console.log(data.length());
            for (var i = 0; i < data.length; i++) {
                var contentString = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h3 id="firstHeading" class="firstHeading">' + data[i].lokasi + '</h3>' +
                    '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                var latLng = new google.maps.LatLng(data[i].lat, data[i].lng);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
            }
        });
    });
</script>