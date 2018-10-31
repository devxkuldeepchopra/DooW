import { Component, OnInit, ElementRef } from '@angular/core';
import { Router, Routes, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { PostService } from '../../../../_services/post/post.service';
import { formControlBinding } from '@angular/forms/src/directives/ng_model';
import { ToastrService } from 'ngx-toastr';

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
  // public editorContent: string = 'My Document\'s Title'
  // Constructor 
  constructor(private activeRoute : ActivatedRoute,
    private fb:FormBuilder,
    private postservice : PostService,
    private toastr : ToastrService, private ef:ElementRef ) { }

  // Validation Message For Reactive Form
  validation_messages = {
    'title': [
      { type: 'required', message: 'Title is required' }
    ]
  }

  public options: Object = {
    charCounterCount: true,
    imageUploadParam: 'image_param',
    imageUploadURL: 'assets/uploads',
    imageUploadParams: {id: 'my_editor'},
    imageUploadMethod: 'POST',
    imageMaxSize: 5 * 1024 * 1024,
    imageAllowedTypes: ['jpeg', 'jpg', 'png'],
    events: {
      'froalaEditor.initialized':  function () {
        debugger;
      console.log('initialized');
    },
      'froalaEditor.image.beforeUpload':  function  (e,  editor,  images) {
        debugger;
        if  (images.length) {
        const  reader  =  new  FileReader();
        reader.onload  =  (ev)  =>  {
        const  result  =  ev.target['result'];
        editor.image.insert(result,  null,  null,  editor.image.get());
        console.log(ev,  editor.image,  ev.target['result'])
      };
      reader.readAsDataURL(images[0]);
    }
    return  false;
  }

}
  }

  ngOnInit() {
    this.GetCategory();
    this.addPost="Add Post";
     let url = this.activeRoute.snapshot.params.id;
     this.Form();
     if(url)
       this.GetPostByUrl(url)
  
  }
RemoveNull(val){
  return val == "null" ? "" : val;
}
  GetPostByUrl(url){
    this.postservice.GetPostByUrl(url).subscribe((data:any)=>{
      debugger;
      this.addPost = "Update Post";
      let body = data[0];
      this.PostForm.reset({
        id : body.PostId,
        postcatid: body.PostCatId,
        title : body.Title,
        description : this.RemoveNull(body.Description),
        video : body.Video,
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
      video : new FormControl(),
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
    debugger;
    this.postservice.AddPost(this.fileToUpload,value).subscribe((data: any)=>{
    debugger; 
    var updated = "Updated.";
    if(data == "0"){ this.toastr.success(updated); return;}
    this.toastr.success("Added :"+data);
    this.thumbnailPath = "assets/images/thumbnaillogo.png";
    this.PostForm.reset();
    })
  }

  GetCategory() {
    debugger;
    this.postservice.GetCategory().subscribe((data: any)=>{
    debugger;
    this.categories = data;
    })
  }

}
