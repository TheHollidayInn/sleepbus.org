           <div style="padding:25px;">
            <div id="input_text">
             <?php
			 
              echo form_open_multipart(base_url().admin.'/blogs/validate-blog',$attributes['form']);
			  
			 if(!empty($blog_id)) echo form_hidden('blog_id',$blog_id);
			 ?>
              <table width="98%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                <td style="padding-bottom:9px;">
                 <span class="main_heading"><?php echo $page_title;?></span>
                </td>
                <td colspan="3">
                  <div class="error1" id="error"><?php if(isset($error_msg)) echo $error_msg; ?></div>
                 </td>
               </tr>
               
			   <tr><td style="padding-top:0px;padding-bottom:5px;">
                 *Select a category&nbsp;<span class="error1" id="error4"><?php echo form_error('cat_id'); ?></span>
               </td></tr>
               
               <tr>
                <td colspan="4" align="left" valign="top">
                 <?php 
				 $disabled = '';
				 if(!empty($blog_id)) $disabled = 'disabled';
				 echo form_dropdown('cat_id',$attributes['cat_id'], $attributes['selected_item_category'],"class='select_action' style='width:150px;' id='cat_id' ")?>     
                
                </td>
               </tr>    
               
              
			   <tr><td style="padding-top:10px;padding-bottom:5px;">
                 *Blog Title&nbsp;<span class="error1" id="error1"><?php echo form_error('blog_name'); ?></span>
               </td></tr>
               
               <tr>
                <td colspan="4" align="left" valign="top">
                 <?php echo form_input($attributes['blog_name']); ?>&nbsp;<span><?php echo form_input($attributes['limit1']);
				  ?></span><span class="remarks">&nbsp;(Max. 100 chars)</span>
                </td>
               </tr> 
               
               <tr><td style="padding-top:10px;padding-bottom:5px;">
                 *Select Date 
               </td></tr>
               <tr>
                <td colspan="4" align="left" valign="top">
                 <?php echo form_input($attributes['date_display']); ?>&nbsp;
                 <img src="<?php echo base_url();?>/images/<?php echo admin;?>/icons/tools/calender.gif" id="date_selected_trigger" style="position:relative; top:5px; cursor:pointer; height:18px" >
                        <script type="text/javascript">
                          new Calendar({
                                  inputField: "date_display",
                                  dateFormat: "%d-%m-%Y",
                                  trigger: "date_selected_trigger",
                                  bottomBar: false,
                                  onSelect: function() {
                                          var date = Calendar.intToDate(this.selection.get());
                                         /* LEFT_CAL.args.min = date;
                                          LEFT_CAL.redraw();*/
                                          this.hide();
                                  }
                          });
                          function clearRangeStart() {
                                  document.getElementById("date_display").value = "";
                                  LEFT_CAL.args.min = null;
                                  LEFT_CAL.redraw();
                          };
                        </script>
                </td>
               </tr>    
 <tr><td style="padding-top:20px;padding-bottom:5px;">
                 *Select a blogger&nbsp;<span class="error1" id="error5"><?php echo form_error('blogger_id'); ?></span>
               </td></tr>
               
               <tr>
                <td colspan="4" align="left" valign="top">
                 <?php 
				 $disabled = '';
				 if(!empty($blog_id)) $disabled = 'disabled';
				 echo form_dropdown('blogger_id',$attributes['blogger_id'], $attributes['selected_item_blogger'],"class='select_action' style='width:150px;' id='blogger_id' ")?>     
                 
                </td>
               </tr>    
               
			   <tr>
                <td style="padding-top:10px;padding-bottom:5px;">
                 *Intro text & image<span class="remarks">&nbsp;(to be displayed on blog landing page as a list item)</span>
                 &nbsp;<span class="error1" id="error2"><?php echo form_error('intro_text'); ?></span>
                </td>
               </tr>
               <tr>
                <td colspan="4" align="left" valign="top">
                 <?php echo form_textarea($attributes['intro_text']);
				 
   				       $this->ckeditor->config['width'] = '700px';
					   $this->ckeditor->config['height'] = '300px';            
					   echo $this->ckeditor->replace("intro_text");
		     	  ?>
                  
                </td>
               </tr>    
<tr>
                <td style="padding-top:10px;padding-bottom:5px;">
                 *Banner Content<span class="remarks">&nbsp;(to be displayed at the top of blog detail page)</span>
                 &nbsp;<span class="error1" id="error6"><?php echo form_error('banner_image_text'); ?></span>
                </td>
               </tr>
               <tr>
                <td colspan="4" align="left" valign="top">
                 <?php echo form_textarea($attributes['banner_image_text']);
				 
   				       $this->ckeditor->config['width'] = '700px';
					   $this->ckeditor->config['height'] = '300px';            
					   echo $this->ckeditor->replace("banner_image_text");
		     	  ?>
                  
                </td>
               </tr>    
               <tr>
                <td style="padding-top:8px;padding-bottom:5px;">
                *Description&nbsp;<span class="error1" id="error3"><?php echo form_error('description'); ?></span>
                </td>
               </tr>
               <tr>
                <td colspan="4" align="left">
                  <?php echo form_textarea($attributes['description']); 
   				       $this->ckeditor->config['width'] = '700px';
					   $this->ckeditor->config['height'] = '300px';            
					   echo $this->ckeditor->replace("description");
		     	 ?>  
                </td>
               </tr>

               <tr>
                <td colspan="4" align="left" valign="top" style="padding-top:10px;">
                 <?php echo form_submit($attributes['submit']); ?>
                </td>
               </tr>    

               <tr><td colspan="4" height="10" style="padding-top:10px;padding-bottom:10px;">
               </td></tr>
              </table> 
			 <?php
              echo form_close();
             ?>  
            </div>
           </div>