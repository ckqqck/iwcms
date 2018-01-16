<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="inbox-page">
					<h4>用户管理</h4>
					<?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
					<div class="inbox-row widget-shadow" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="mail "> <input type="checkbox" class="checkbox"> </div>
						<div class="mail"><img src="<?php echo base_url(); ?>static/admin/images/i1.png" alt=""/></div>
						<div class="mail mail-name"> <h6><?php echo $record->name ?></h6> </div>
						<div class="mail"><p><?php echo $record->email ?></p></div>
						<div class="mail"><p><?php echo $record->mobile ?></p></div>
						<div class="mail"><p><?php echo $record->role ?></p></div>
						<div class="mail-right">
							<div class="dropdown">
								<a href="#"  data-toggle="dropdown" aria-expanded="false">
									<p><i class="fa fa-ellipsis-v mail-icon"></i></p>
								</a>
								<ul class="dropdown-menu float-right">
									<li>
										<a href="<?php echo base_url().'editOld/'.$record->userId; ?>" title="">
											<i class="fa fa-file-text-o mail-icon"></i>
											Archive
										</a>
									</li>
									<li>
										<a href="#" class="font-red  deleteUser" data-userid="<?php echo $record->userId; ?>">
											<i class="fa fa-trash-o mail-icon "></i>
											Delete
										</a>
									</li>
								</ul>
							</div> 
						</div>
						<div class="mail-right"><p><?php echo $record->userId; ?></p></div>
						<div class="clearfix"> </div>
					</div>
					<?php
                        }
                    }
                    ?>
				</div>
				<?php echo $pageurl;?>
			</div>
		</div>
<!-- Classie -->

<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/js/common.js" charset="utf-8"></script>