
<section id="container" class="">

<section id="main-content">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Staff Search Results
</header>
<div class="panel-body">
<div class="adv-table">
    
<table class="display table table-bordered table-striped" id="patients">
<thead>
    
    
<tr>
<th>Staff Number</th>
<th>Name</th>
<th>Department</th>
<th>Role</th>
<th>Sex</th>

</tr>
</thead>
<tbody>
<?php foreach($staffs as $staff){ ?>
<tr class="gradeX">
<td><a href="<?=base_url() ?>index.php/staff/number/<?php echo $staff['staff_no']; ?>"><?php echo $staff['staff_no']; ?></a></td>
<td><?php echo ucfirst($staff['first_name'])." ".ucfirst($staff['middle_name'])." ".ucfirst($staff['last_name']); ?></td>
<td><?php

foreach($departments as $department)
{
    if($department['dept_id'] == $staff['dept_id'])
    {
        echo $department['name'];
    }
}



?></td>
<td><?php

foreach($roles as $role)
{
    if($role['role_id'] == $staff['role_id'])
    {
        echo $role['role_name'];
    }
}



?></td>
<td><?php echo $staff['sex']; ?></td>
</tr>

<?php }?>
</tbody>

</table>
</div>
</div>
</section>
</div>
</div>
 
</section>
</section>
 
 