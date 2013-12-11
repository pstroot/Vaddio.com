<div class='header big-blue-header dealers-header'>
    <div class="dealers-icon"><span>Dealers</span></div>
    <h1>My Info</h1>
</div>



<a href='<?= base_url(); ?>my_info/editInfo' class='rounded-corner-button orange-button'>Edit Info</a>
<a href='<?= base_url(); ?>my_info/editPassword' class='rounded-corner-button orange-button'>Edit Password</a>

<dl>
    <dt>Name:</dt><dd><?= $user->user_name;?>&nbsp;</dd>
    <dt>Company:</dt><dd><?= $user->user_company;?>&nbsp;</dd>
    <dt>Address:</dt><dd><?= $user->user_address;?>&nbsp;</dd>
    <dt>Phone:</dt><dd><?= $user->user_phone;?>&nbsp;</dd>
    <dt>Fax:</dt><dd><?= $user->user_fax;?>&nbsp;</dd>
    <dt>Email:</dt><dd><?= $user->user_email;?>&nbsp;</dd>
    <dt>Username:</dt><dd><?= $user->user_username;?>&nbsp;</dd>
</dl>


<a href='<?= base_url(); ?>logout' class='rounded-corner-button yellow-button'>Log Out</a>
