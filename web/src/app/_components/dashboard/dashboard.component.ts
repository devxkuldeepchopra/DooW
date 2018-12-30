import { Component, OnInit } from '@angular/core';
import { PostService } from '../../_services/post/post.service';
import { DataService } from '../../_services/data.service';
import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
data : any[];
PostId:any;
  constructor(private _post : PostService,
  private dataservice : DataService,
  private toastr: ToastrService,
  private spinner: NgxSpinnerService
) { }

  ngOnInit() {
    this.spinner.show();
    this._post.GetPost().subscribe((data:any)=>{
      this.spinner.hide();
      
      this.data = data.post;
    })

    this.dataservice.deleteData.subscribe(id=>{
      this.spinner.show();
      
      if(id>0){
      this.data = this.data.filter(c=>c.Id !== id);
      this._post.DeletePost(id).subscribe((res:any)=>{ 
        this.spinner.hide();
        if(res>0){
          
          this.toastr.success('Deleted.', '');
        }
      },
      error => {console.log(error)});
    }
    })
  }
  getId(data){
    
    this.PostId = data.Id;
  }
}




  