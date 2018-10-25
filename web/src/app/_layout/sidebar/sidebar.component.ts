import { Component, OnInit } from '@angular/core';
import { PostService } from 'src/app/_services/post/post.service';
import { NgxSpinnerService } from '../../../../node_modules/ngx-spinner';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  host: {'class': 'col-sm-4'},
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements OnInit {
  posts: any[] = [];
  page: number = 1;
  content : number = 6;
  constructor(    private postService: PostService,
    private spinner: NgxSpinnerService) { }

  ngOnInit() {
    this.Home();
  }
  Home() {
    this.posts = [];
    this.spinner.show();
    this.postService.GetPost().subscribe((data:any)=>{
      this.spinner.hide();
      this.posts = data.post;
    },
    (error :any)=> {
      this.spinner.hide();
      console.log(error);
    });
  }

}
