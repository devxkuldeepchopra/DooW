import { Component, OnInit } from '@angular/core';
import { PostService } from '../../../../_services/post/post.service';
import { DataService } from '../../../../_services/data.service';
import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from 'ngx-spinner';
import { PushNotification, NotificationContent } from 'src/app/dto/PushNotification';


@Component({
  selector: 'app-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.css']
})
export class ListComponent implements OnInit {
  data : any[];
  PostId:any;
  Tokens: any[] = [];
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
      this.PostId = data.Id;
    }

    ConfirmDelete(Delete) {
      this.spinner.show();
     
      this._post.DeletePost(Delete.Id).subscribe((res:any) => { 
        this.spinner.hide();
        if(res > 0) {  
          
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
      
      this._post.ActivatePost(id,activate).subscribe((data:any)=>{
        
        if(data == "0") {
          this.data.filter(x=>{ if(x.Id==id) {
            
            x.IsActive = activate==1?0:1;
          } });
        }
      })
    }

    PushWeb(item) {
    //  this.spinner.show();     
      
      if(this.Tokens.length>0){
        this.SendNotifications(item,this.Tokens);
      }
      else{
        this._post.GetPushToken().subscribe(x=>{
          
          x.forEach(e => {
            this.Tokens.push(e.Token);
          });
          this.SendNotifications(item,this.Tokens);
        });
      }
    }
    SendNotifications(item:any,tokens:any[]){
      let domain = "https://doomw.com/";
      let url = domain+item.Url;
      let pushObj = new PushNotification();
      let notification = new NotificationContent();
      notification.body = item.Description;
      notification.click_action = url;
      notification.icon = domain+'web/assets/images/thumbnail/'+item.ImageUrl;
      notification.title = item.Title;
      pushObj.priority = 10;
      pushObj.registration_ids = tokens;
      pushObj.notification = notification;
      this._post.PushWeb(pushObj).subscribe((data:any)=>{
        
        if(data){
          let message = "total: [" + data.results.length + "] Failed: ["+ data.failure + "]";
          let title = "Fcm Job";
          this.toastr.success(message,title);
          console.log(data); 
        }
        else{
          let error = "Failed";
            this.toastr.error(error)
        }
      
      },
      (error:any)=>{
        this.toastr.error(error)
        console.log(error);     
      }
      )
    }
}

