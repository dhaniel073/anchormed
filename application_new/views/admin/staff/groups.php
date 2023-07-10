
<section id="container" class="">

<section id="main-content">
<form name="permission-form" id="permission-form" action="<?=base_url()?>index.php/staff/savePermission" method="POST">
<section class="wrapper site-min-height">
 
<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
<?php echo ucfirst($user_group['name'])." User Group ~ Permisions" ?>
<input type="hidden" name="user_group_id" value="<?php echo $user_group['user_group_id']; ?>"/>
</header>
<div class="panel-body">
<div class="adv-table">
    

    
<?php foreach($modules as $module){?>
<section class="panel">
<header class="panel-heading">
<?php echo ucfirst($module['module_name']); ?>
</header>
</section>



<table class="display table table-bordered table-striped" >
<thead>
    
    
<tr>
<th width="35%">Name</th>
<th width="65%">Permission</th>

</tr>
</thead>
<tbody>
    
        <?php foreach($submodules as $m){
        
        if($m['module_id'] == $module['module_id'] )
        {
               $access = '';
               foreach($permissions as $permission)
               {
                    if($permission['module_id'] == $m['module_id'] && $permission['sub_module_id'] == $m['sub_module_id'])
                    {
                        $access = $permission['access'];
                    }
               }
        
        ?>
            <tr>
            <td style="color:#145FBE; font-weight:bold;"><?php echo ucwords($m['sub_name']); ?></td>
            <td>
                
                <div class="form-group">
                   
                   <input type="hidden" name="module_id[]" value="<?php echo $module['module_id']; ?>"/>
                   <input type="hidden" name="sub_module_id[]" value="<?php echo $m['sub_module_id']; ?>"/>
                   
                   
                     <select name="permission[]"  class="form-control m-bot15">
                            <option value="N">No Access</option>
                            <option value='W' <?php if($access == 'W') echo "selected='selected'"; ?>>Granted</option>
                            
        
    
        
    </select></div>
            </td>
            
            </tr>
            
            
        
    <?php  } }?>
    
    
    </tbody>
</table>
    




<?php }?>



<hr/>

<button type="button" id="find_patient" class="btn btn-default" onclick="javascript:apply();">Apply Permissions</button>

<script>
    
    function apply(args) {
        
        $("form#permission-form").submit();
        //code
    }
</script>

</div>
</div>
</section>
</div>
</div>
 
</section>
</section>
</form>
 