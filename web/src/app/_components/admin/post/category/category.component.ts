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
      { type: 'required', message: 'Contact name is required' }
    ]
  }

  ngOnInit() {
     let id = this.activeRoute.snapshot.params.id;
     this.Form();
     if(id)
       this.GetCategoryById(id)
  
  }

  GetCategoryById(id) {
    this.postservice.GetCategoryById(id).subscribe((data:any)=>{
      debugger;
      let body = data[0];
      this.PostForm.reset({
        id : body.Id,
        title : body.Title,
        icon : body.Icon        
      });
      this.thumbnailPath = 'assets/uploads/'+body.ImageUrl;
    });
  }

  Form() {
    this.PostForm = this.fb.group({
      id: new FormControl(''),
      title : new FormControl('',{
        validators : Validators.compose([
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

  AddPost(value) {
    debugger;
    this.postservice.AddCategory(this.fileToUpload,value).subscribe((data: any)=>{
    debugger;
    this.Form();
    this.thumbnailPath = "assets/images/thumbnaillogo.png";
    this.toastr.success(data);
    })
  }

}
