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
							<h4>增加用户:</h4>
						</div>
						<?php
                    $this->load->helper('form');
                ?>
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						<div class="form-body" data-example-id="simple-form-inline">
						<form role="form" action="<?php echo base_url() ?>addNewUser" method="post" id="addUser" role="form">
						<div class="row">
							<div class="col-md-5 grid_box1">
								<div class="form-group"> <label for="fname">Name</label> <input type="text" class="form-control" id="fname" placeholder="Name" name="fname" maxlength="128"> </div>
								<div class="form-group"> <label for="password">Password</label> <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="10"> </div>
								<div class="form-group"> <label for="mobile">Mobile Number</label> <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number"> </div>
								<div class="form-group"><label id="captchaOperation"></label><input type="text" class="form-control" name="captcha" /></div>
							</div>
							<div class="col-md-7">
								<div class="form-group"> <label for="email">Email address</label> <input type="email" class="form-control" id="email" placeholder="Email" name="email" maxlength="128"> </div>
								<div class="form-group"> <label for="cpassword">Confirm Password</label> <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" maxlength="10"> </div>
								<div class="form-group"> <label for="role">Role</label> 
									<select id="role" name="role" class="form-control1" data-bv-notempty data-bv-notempty-message="The country is required">
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
							<input type="submit" class="btn btn-primary" value="提交" />
                            <input type="reset" class="btn btn-default" value="Reset" />
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
<link rel="stylesheet" href="<?php echo base_url(); ?>static/common/css/bootstrapValidator.css"/>
<script src="<?php echo base_url(); ?>static/common/js/bootstrapValidator.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Generate a simple captcha
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

    $('#addUser').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            fname: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            email: {
                validators: {
                	notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    identical: {
                        field: 'cpassword',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            cpassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            mobile: {
                validators: {
                	notEmpty: {
                        message: 'The mobile is required and cannot be empty'
                    },
                    stringLength: {
                        min: 10,
                        max: 12,
                        message: '用户名长度必须在10到12之间'
                    }
                }
            },
            
            captcha: {
                validators: {
                    callback: {
                        message: 'Wrong answer',
                        callback: function(value, validator) {
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            }
        }
    });

    // Validate the form manually
    $('#validateBtn').click(function() {
        $('#defaultForm').bootstrapValidator('validate');
    });

    $('#resetBtn').click(function() {
        $('#defaultForm').data('bootstrapValidator').resetForm(true);
    });
});
</script>