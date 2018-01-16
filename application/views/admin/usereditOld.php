<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';
$roleId = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->mobile;
        $roleId = $uf->roleId;
    }
}
?>
<style>
.form-body .form-inline {

	padding: 0.5em;

}
.form-body .form-inline{

	padding: 0.5em;

}
</style>		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<div class="form-two widget-shadow">
						<div class="form-title">
							<h4>Inline form Example 2 :</h4>
						</div>
						<div class="form-body" data-example-id="simple-form-inline">
						<form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
							<input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
							<div class="row">
							<div class="col-md-5 grid_box1">
								<div class="form-group"> <label for="fname">Name</label> <input type="text" class="form-control" id="fname" placeholder="Name" name="fname" maxlength="128" value="<?php echo $name;?>"> </div>
								<div class="form-group"> <label for="password">Password</label> <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="10" > </div>
								<div class="form-group"> <label for="mobile">Mobile Number</label> <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" value="<?php echo $mobile;?>"> </div>
							</div>
							<div class="col-md-7">
								<div class="form-group"> <label for="email">Email address</label> <input type="email" class="form-control" id="email" placeholder="Email" name="email" maxlength="128" value="<?php echo $email;?>"> </div>
								<div class="form-group"> <label for="cpassword">Confirm Password</label> <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" maxlength="10"> </div>
								<div class="form-group"> <label for="role">Role</label> 
									<select name="role" id="selector1" class="form-control1">
										<?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
									</select> </div>
							</div>
							<div class="clearfix"> </div>
						</div>
							<div class="form-inline"> 
							<button type="submit" class="btn btn-default">提交</button> 
							</div> 
 
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--footer-->
		<div class="footer">
		   <p>Copyright &copy; 2016.Company name All rights reserved.More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></p>
		</div>
        <!--//footer-->
	<!-- Classie -->
<script src="<?php echo base_url(); ?>static/admin/js/addUser.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/admin/js/jquery.validate.js" type="text/javascript"></script>