import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';
import { Router, Routes, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { PostService } from '../../../../_services/post/post.service';
import { formControlBinding } from '@angular/forms/src/directives/ng_model';
import { ToastrService } from 'ngx-toastr';
import { PlatformLocation } from '@angular/common' 
import { find } from 'rxjs/operators';
declare var $: any;
declare var CKEDITOR:any;
@Component({
  selector: 'app-add',
  templateUrl: './add.component.html',
  styleUrls: ['./add.component.css']
})
export class AddComponent implements OnInit {
  
  PostForm : FormGroup;
  id: FormControl;
  postcatid : FormControl;
  post : any = {};
  categories : any = [];
  thumbnailPath: string = "assets/images/thumbnaillogo.png";
  fileToUpload: File = null;
  addPost : string ;
  ckeConfig: any;
  log: string = '';
  @ViewChild("myckeditor") ckeditor: any;

  constructor(private activeRoute : ActivatedRoute,
    private fb:FormBuilder,
    private postservice : PostService,
    private toastr : ToastrService, private ef:ElementRef,
    private location: PlatformLocation
    ) {
     }

  validation_messages = {
    'title': [
      { type: 'required', message: 'Title is required' }
    ]
  }

  loadJquery(){  
    $("ckeditor").ready(function(){      
      var id = setInterval(function(){       
        if($(document).find(".cke_button__image_icon")){
          $(".cke_button__image_icon").click(function(){
            if($(".cke_dialog_ui_hbox_last").find("#img-up").length > 0){
              //return false;
            }else{
              var fbtn = setInterval(function(){
                if( $(".cke_dialog_ui_hbox_last")){
                  $(".cke_dialog_ui_hbox_last").each(function(i,e){
                    if(i==0){
                      $(this).append("<input type='file' id='img-up' />");
                      $("#img-up").change(function() {
                        var reader = new FileReader();
                          reader.onload = (event:any) => {
                            $(".cke_dialog_image_url").find(".cke_dialog_ui_input_text").val(event.target.result);
                                console.log(event.target.result);
                          }
                          reader.readAsDataURL($(this)[0].files[0]);
                      });
                      clearInterval(fbtn);
                      return false;
                    }
                  });
                }
              },1);
            }
          });
          clearInterval(id);
        }
        }, 
         1000);
    });
  }

  ngOnInit() {
    let url = this.activeRoute.snapshot.params.id;
    this.loadJquery();
    this.GetCategory();
    this.LoadCkeConfig();
    this.handleBackBtn();
    //this.ckeditorInstaceReady();
    this.addPost="Add Post";
    this.Form();
    if(url)
      this.GetPostByUrl(url)
  
  }

  LoadCkeConfig(){
    this.ckeConfig = {
      allowedContent: false,
      extraPlugins: 'divarea',
      forcePasteAsPlainText: false,
      tabSpaces:4,
      wsc_cmd: 'thes',   //'spell', 'thes', 'grammar'
      shiftEnterMode: 1,
      enterMode: 2,   //forceEnterMode = true
      height:'300px'
    };
  }
  ckeditorInstaceReady(){
    CKEDITOR.on('instanceReady',
    function( evt )
      {
      
     var editor = evt.editor;
     editor.execCommand('maximize');
      });
  }
  RemoveNull(val){
    return val == "null" ? "" : val;
  }

  GetPostByUrl(url){
    this.postservice.GetPostByUrl(url).subscribe((data:any)=>{
      
      this.addPost = "Update Post";
      let body = data[0];
      this.PostForm.reset({
        id : body.PostId,
        postcatid: body.PostCatId,
        title : body.Title,
        description : this.RemoveNull(body.Description),
        mypost : this.RemoveNull(body.Post),
        category: body.CatId,
        fileName : body.ImageUrl
      });
      // uncomment on live
      // this.thumbnailPath = 'assets/uploads/'+body.ImageUrl;
      if(body.ImageUrl && body.ImageUrl != "null"){
        this.thumbnailPath = 'http://doomw.com/web/assets/images/uploads/'+body.ImageUrl;
      }     
    });
  }

  Form() {
    this.PostForm = this.fb.group({
      id: new FormControl(''),
      postcatid: new FormControl(''),
      title : new FormControl('',{
        validators : Validators.compose([
          Validators.required
        ]),
        updateOn: 'change'
      }),
      description : new FormControl(''),
      mypost : new FormControl(),
      category: new FormControl(),
      fileName: new FormControl()
    },
    {updateOn: 'submit'})
  }

  handleFileInput(file: FileList) {
    this.fileToUpload = file.item(0);
    var reader = new FileReader();
    reader.onload = (event:any) => {
      this.thumbnailPath = event.target.result;
    }
    reader.readAsDataURL(this.fileToUpload);
  }

  AddPost(value) {
    
    this.postservice.AddPost(this.fileToUpload,value).subscribe((data: any)=>{
     
    var updated = "Updated.";
    if(data == "0"){ this.toastr.success(updated); return;}
    this.toastr.success("Added :"+data);
    this.thumbnailPath = "assets/images/thumbnaillogo.png";
    this.PostForm.reset();
    })
  }

  GetCategory() {
    
    this.postservice.GetCategory().subscribe((data: any)=>{
    
    this.categories = data;
    })
  }

  onChange($event: any): void {
   // console.log("onChange");
    //this.log += new Date() + "<br />";
  }

  handleBackBtn(){
    this.location.onPopState(() => {
     location.reload();
  });
  }
}
