<div class='header big-blue-header'>
    <h1>Camera Tracking Certification</h1>
</div>

<h2>Sales/Engineering Online Camera Tracking Certification</h2>



<section id='course-description'>
    <p><b>Course Description</b></p>
    
    <p>This free, online tutorial teaches integrators, dealers, and consultants how to design Vaddio AutoTrak Camera Tracking Systems. The course lasts 1.5 hours.</p>
    <p>Certification requires the completion of a 60-minute online exam within 10 days of the course session. You must pass this exam in order to submit a purchase order for any tracking system products.</p>
    <p>Visit <a href='<?=base_url();?>training/whyCertify'>Why Certify?</a> to learn about the benefits of certification.</p>
    
    <p><b>Who should attend?</b></p>
    <p>This course is ideal for anyone working with Vaddio AutoTrak Camera Tracking Systems:</p>
    <ul class='bulleted-list'>
        <li>Sales staff</li>
        <li>System design engineers</li>
        <li>Consultants</li>
        <li>Installation technicians</li>
    </ul>
</section>




<section id='whats-covered'>
<p><b>What will be covered?</b></p>
<p>This course covers the Vaddio AutoTrak Camera Tracking systems.</p>    
<ul class='bulleted-list'>
    <li>Understanding customer requirements</li>
    <li>Tracking system basics</li>
    <li>System capabilities and limitations</li>
    <li>Room and equipment installation requirements</li>
    <li>Interfacing with other Vaddio and third-party hardware</li>
    <li>Vaddio and dealer responsibility</li>
    <li>Warranty information</li>
</ul>


<? 
if(isset($moreinfo["Downloads"]) && count($moreinfo["Downloads"]) > 0){ 
	echo "<ul class='downloads downloads-downloads'>";
    foreach($moreinfo["Downloads"] as $doc){
        if($doc["type"] == "anchor") continue;
        echo "<li>";
        echo "<a href='" . $doc["path"] . "'>";
        echo $doc["description"];
        if(isset($doc["type"])) print " (".$doc["type"].")";
        echo "</a>";
        echo "</li>";
    } 
	echo "</ul>";
}
?>
</section>

