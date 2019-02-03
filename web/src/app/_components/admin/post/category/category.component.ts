import { Component, OnInit } from '@angular/core';
import { Router, Routes, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { PostService } from '../../../../_services/post/post.service';
import { formControlBinding } from '@angular/forms/src/directives/ng_model';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.css']
})
export class CategoryComponent implements OnInit {

  PostForm : FormGroup;
  id: FormControl;
  post : any = {};
  thumbnailPath: string = "assets/images/thumbnaillogo.png";
  fileToUpload: File = null;

  constructor( private activeRoute : ActivatedRoute,
    private fb:FormBuilder,
    private postservice : PostService,
    private toastr : ToastrService ) { }

  validation_messages = {
    'title': [
      { type: 'required', message: 'Name is required' },
      { type: 'maxlength', message: 'Name Should not be exceeded more than 20 characters' }
    ]
  }

  ngOnInit() {
    
     let id = this.activeRoute.snapshot.params.id;
     this.Form();
     debugger;
     if(id)
       this.GetCategoryById(id)
  
  }

  GetCategoryById(id) {
    
    this.postservice.GetCategoryById(id).subscribe((data:any) => {
      
      console.log(data);
      let body = data[0];      
      if(body.Icon != null) {
        // this.thumbnailPath = 'assets/images/icon/'+body.ImageUrl;
        this.thumbnailPath = 'http://doomw.com/web/assets/images/icon/'+body.Icon;
      }
      this.PostForm.reset({
        id : body.Id,
        title : body.Name,
        icon : body.Icon        
      });
    },
    (error : any) => {
      console.log(error);
    });
  }

  Form() {
    this.PostForm = this.fb.group({
      id: new FormControl(''),
      title : new FormControl('',{
        validators : Validators.compose([
          Validators.maxLength(200),
          Validators.required
        ]),        
        updateOn: 'change'
      }),
      icon: new FormControl()
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

  AddCategory(value) {
    
    this.postservice.AddCategory(this.fileToUpload,value).subscribe((data: any)=>{
    
    var updated = "Updated.";
    if(data == "0"){ this.toastr.success(updated); return;}
    this.toastr.success("Added :"+data);
    this.thumbnailPath = "assets/images/thumbnaillogo.png";
    this.PostForm.reset();
    },
    (error : any) => {
      console.log(error);
    })
  }

}
