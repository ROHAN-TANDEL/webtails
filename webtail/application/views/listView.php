<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="">
							<div class="panel panel-primary filterable">
								<div class="panel-heading" style="margin:3%">
									
									<center>
										<h3 class="panel-title">Students</h3>
									</center>
									<h3 class="panel-title " style="float: right; margin-left:2%;"><img class="pull-right" src="http://www.clker.com/cliparts/R/3/q/f/H/n/power-button-md.png" width="20px" height="20px" /></h3>
								</div>
								<table class="table" style="padding: 11px; margin:1%">
									<thead>
										<tr class="filters">
											<?php foreach($viewData['header'] as $headers=>$classes):?>
											<th class='<?php echo $classes; ?>'><input type="text" class="form-control" placeholder="<?php echo $headers; ?>"></th>
											<?php endforeach; ?>
											<th>
											<a href="">
												<img src="https://cdn2.iconfinder.com/data/icons/weby-flat-vol-1/512/1_Add-additional-plus-create-new-expand-512.png" width="30px" height="30px"/> 
											</a>
										</th>
											<th><img src="https://www.freepnglogos.com/uploads/search-png/search-icon-clip-art-clkerm-vector-clip-art-online-0.png" width="30px" height="30px"/></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($viewData['data'] as $list):?>
										<tr id="filter-list-<?php echo$list['_id']; ?>">
											<td class="hidden-xs-down"><?php echo $list['studentName']; ?></td>
											<td><?php echo $list['subjectName']; ?></td>
											<td><?php echo $list['marks']; ?></td>
											<td>
												<a href="">
												<img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/edit-user-1-483615.png" width="30px" height="30px"/> 
											</a>
										</td>
										<td>
												<a href="<?php print_r( $viewData['deleteAPI'].$list['_id'] ); ?> " onclick='deleteItem(<?php echo$list["_id"];?>);'>
													<img src="https://cdn2.iconfinder.com/data/icons/ios-7-tab-bar-icons/500/trash-512.png" width="30px" height="30px"/>
												</a>
											</td>
										<?php endforeach;?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<nav class="navbar fixed-bottom" aria-label="...">
									<ul class="pagination justify-content-center ">
									  <li class="page-item disabled">
										<span class="page-link px-color-orange px-bgcolor-orange">Previous</span>
									  </li>
									  <li class="page-item"><a class="page-link px-color-orange" href="#">1</a></li>
									  <li class="page-item active">
										<span class="page-link px-color-orange px-bgcolor-orange">
										  2
										  <span class="sr-only">(current)</span>
										</span>
									  </li>
									  <li class="page-item"><a class="page-link px-color-orange" href="#">3</a></li>
									  <li class="page-item">
										<a class="page-link px-color-orange" href="#">Next</a>
									  </li>
									</ul>
								  </nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>