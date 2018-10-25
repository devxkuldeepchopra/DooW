import { Component, OnInit } from '@angular/core';
import { PostService } from 'src/app/_services/post/post.service';
import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-list-category',
  templateUrl: './list-category.component.html',
  styleUrls: ['./list-category.component.css']
})
export class ListCategoryComponent implements OnInit {
  categories : any[]; 
  public popoverTitle: string = 'Attention!';
  public popoverMessage: string = 'Are you sure to delete this Post?';
  public confirmClicked: boolean = false;
  public cancelClicked: boolean = false;

  constructor( private _post : PostService,
    private toastr: ToastrService,
    private spinner: NgxSpinnerService
  ) { }

  ngOnInit() {
    this.GetCategory(); 
  }

  GetCategory() {
    debugger;
    this._post.GetCategory().subscribe((data: any)=>{
    debugger;
    this.categories = data;
    })
  }

  ConfirmDelete(deleteCategory) {
    debugger;
    this.spinner.show();   
    this._post.DeleteCategory(deleteCategory.Id).subscribe((res:any) => { 
      this.spinner.hide();
      if(res > 0) {  
        debugger;
        this.categories = this.categories.filter(c=>c.Id !== deleteCategory.Id);         
        this.toastr.success('Deleted.', '');
      }
    },
    error => {
      this.spinner.hide();
      console.log(error);
    });
  }

}
