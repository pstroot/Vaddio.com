<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAz2AbnOeTQfbJMVs3AkR2lKuentaIpByw&sensor=false"></script>
<script type="text/javascript">
    
    var vaddioLatLng;
    
    function initialize() {
        vaddioLatLng = new google.maps.LatLng(44.977769, -93.458695);
        var mapOptions = {
            center: vaddioLatLng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.TERRAIN,
            disableDefaultUI: true,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            disableDoubleClickZoom: true,
            draggable: false
        };
        var map = new google.maps.Map(document.getElementById("contact_map"),mapOptions);
        var marker = new google.maps.Marker({
            position: vaddioLatLng,
            map: map,
            title:"Vaddio"
        });
        google.maps.event.addDomListener(window, 'resize', function() { map.setCenter(vaddioLatLng); });
    }
    
    google.maps.event.addDomListener(window, 'load', initialize);

</script>

<div class='header big-blue-header'>
	<h1>Contact Us</h1>
</div>

<div class="contact_map_container">
    <div id="contact_map"></div>
    <div class="contact_pdf">
        Need help finding Vaddio?
        <a href="<?= base_url() ?>files/vaddio_map.pdf" class="rounded-corner-button ltblue-button">Download a PDF Map</a>
    </div>
</div>

<div class="bodyCopy">
    <h3>Street Address</h3>
    <div class='address'>
        Vaddio<br />
        <?= $address; ?><br />
        <?= $address2; ?><br />
        <?= $city; ?>, <?= $state; ?> <?= $zip; ?> 
    </div>
    
    
    <h3>Phone</h3>
    <dl class="phone">
        <dt>Toll Free:</dt><dd><a href="tel:<?= $tollfree; ?>" class="phone-link"><?= $tollfree; ?></a></dd>
        <dt>Phone:</dt><dd><a href="tel:<?= $phone; ?>" class="phone-link"><?= $phone; ?></a></dd>
        <dt>Fax:</dt><dd><?= $fax; ?></dd>
    </dl>
    
    
    <h3>Email</h3>
    <div class="email">
        <ul class="email_col">
            <li>
                <b>Inside Sales</b><br/>
                Stacy Kringlen<br/>
                <a href="mailto:skringlen@vaddio.com">skringlen@vaddio.com</a>
            </li>
            <li>
                <b>International Channel Manager<br/>EMEA and INDIA</b><br/>
                Sally Blank<br/>
                <a href="mailto:sblank@vaddio.com">sblank@vaddio.com</a>
            </li>
            <li>
                <b>Marketing and Communications</b><br/>
                Kelly Perkins<br/>
                <a href="mailto:kperkins@vaddio.com">kperkins@vaddio.com</a>
            </li>
        </ul>
        <ul class="email_col">
            <li>
                <b>VP of Sales</b><br/>
                Tom Mingo<br/>
                <a href="mailto:tmingo@vaddio.com">tmingo@vaddio.com</a>
            </li>
            <li>
                <b>International Channel Manager<br/>LATAM and APAC</b><br/>
                Todd Bergum<br/>
                <a href="mailto:tbergum@vaddio.com">tbergum@vaddio.com</a>
            </li>
            <li>
                <b>Technical Support</b><br/>
                <a href="mailto:support@vaddio.com">support@vaddio.com</a>
            </li>
        </ul>
    </div>
</div>