import { Component, OnInit } from '@angular/core';
import { PostService } from '../../../../_services/post/post.service';
import { DataService } from '../../../../_services/data.service';
import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from 'ngx-spinner';


@Component({
  selector: 'app-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.css']
})
export class ListComponent implements OnInit {
  data : any[];
  PostId:any;
  public popoverTitle: string = 'Attention!';
  public popoverMessage: string = 'Are you sure to delete this Post?';
  public confirmClicked: boolean = false;
  public cancelClicked: boolean = false;


    constructor(private _post : PostService,
    private dataservice : DataService,
    private toastr: ToastrService,
    private spinner: NgxSpinnerService
  ) { }
  
    ngOnInit() {
      this.spinner.show();
      this._post.GetPost().subscribe((data:any)=>{
        debugger;
        this.spinner.hide();        
        this.data = data.post;
      })

      this.dataservice.deleteData.subscribe(id=>{
        this.spinner.show();        
        if(id > 0){
        this.data = this.data.filter(c=>c.Id !== id);
        this._post.DeletePost(id).subscribe((res:any)=>{ 
          this.spinner.hide();
          if(res > 0) {           
            this.toastr.success('Deleted.', '');
          }
        },
        error => {console.log(error)});
      }
      })
    }
    getId(data){     
      debugger; 
      this.PostId = data.Id;
    }
    ConfirmDelete(Delete) {
      this.spinner.show();
     
      this._post.DeletePost(Delete.Id).subscribe((res:any) => { 
        this.spinner.hide();
        if(res > 0) {  
          debugger;
          this.data = this.data.filter(c=>c.Id !== Delete.Id);         
          this.toastr.success('Deleted.', '');
        }
      },
      error => {
        this.spinner.hide();
        console.log(error);
      });
    }
    Active(id,activate){
      debugger;
      this._post.ActivatePost(id,activate).subscribe((data:any)=>{
        debugger;
        if(data == "0") {
          this.data.filter(x=>{ if(x.Id==id) {
            debugger;
            x.IsActive = activate==1?0:1;
          } });
        }
      })
    }

}
