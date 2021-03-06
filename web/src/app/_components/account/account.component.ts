import { Component, OnInit } from '@angular/core';
import { Router, Routes, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { formControlBinding } from '@angular/forms/src/directives/ng_model';
import { ToastrService } from 'ngx-toastr';
import { PostService } from 'src/app/_services/post/post.service';
import { CookieService } from 'ngx-cookie-service';
@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css']
})
export class AccountComponent implements OnInit {
  PostForm : FormGroup;
  id: FormControl;
  post : any = {};
  cookieValue = 'UNKNOWN';
  thumbnailPath: string = "assets/images/thumbnaillogo.png";
  fileToUpload: File = null;

  constructor( private activeRoute : ActivatedRoute,
    private fb:FormBuilder,
    private router:Router,
    private postservice : PostService,
    private toastr : ToastrService,
    private cookieService: CookieService ) { }

  validation_messages = {
    'userName': [
      { type: 'required', message: 'Username is required.' },
    ],
    'password': [
      { type: 'required', message: 'Password is required.' },
    ]
  }

  ngOnInit() {
    
   // this.cookieService.set( 'Test', 'Hello World' );
   // this.cookieValue = this.cookieService.get('Test');
    if(localStorage.getItem('userToken') != null){
      this.router.navigateByUrl('/admin/posts');
      return;
    }
    let id = this.activeRoute.snapshot.params.id;
    this.Form();
    if(id) {
      this.GetCategoryById(id)
    }
        
  
  }

  GetCategoryById(id) {
    
    this.postservice.GetCategoryById(id).subscribe((data:any) => {
      
      console.log(data);
      let body = data[0];      
      if(body.Icon != null) {
        // this.thumbnailPath = 'assets/images/icon/'+body.ImageUrl;
        this.thumbnailPath = '/web/assets/images/icon/'+body.Icon;
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
      userName : new FormControl('',{
        validators : Validators.compose([
          Validators.required
        ]),        
        updateOn: 'change'
      }),
      password : new FormControl('',{
        validators : Validators.compose([
          Validators.required
        ]),        
        updateOn: 'change'
      })
    
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

  Login(value) {
    
    this.postservice.Login(value).subscribe((data: any)=>{
    
    if(data) {
      localStorage.setItem('userToken',data);
      this.router.navigateByUrl('/admin/posts');
      return true;
    }
    else {
       this.toastr.warning("Unauthorized Login.");
       console.log("err:"+ data);
    }
    //this.toastr.success("login :"+data);
    },
    (error : any) => {
      console.log(error);
    })
  }

}
