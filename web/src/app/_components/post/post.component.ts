import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params } from '../../../../node_modules/@angular/router';
import { PostService } from '../../_services/post/post.service';
import { NgxSpinnerService } from '../../../../node_modules/ngx-spinner';

@Component({
  selector: 'app-post',
  templateUrl: './post.component.html',
  host: {'class': 'col-sm-8'},
  styleUrls: ['./post.component.css']
})
export class PostComponent implements OnInit {
posts: any[] = [];
post: any = {isPost: false};
pagination :any[] =[];
page: number = 1;
content : number = 6;
  constructor(
    private activatedRoute: ActivatedRoute,
    private postService: PostService,
    private spinner: NgxSpinnerService            
  ) { }

  ngOnInit() {
    let url = this.activatedRoute.snapshot.paramMap.get('posturl');
    if(url)
      this.GetPostByUrlParms(url);
    else
      this.Home();
  }

  GetPostByUrlParms(url) {
    this.spinner.show();
    this.postService.GetPostByUrl(url).subscribe((data:any)=>{
      this.spinner.hide();      
      this.post = data[0];
      this.post.isPost = true;
      console.log(this.post);
    },
    (error :any)=> {
      this.spinner.hide();
      console.log(error);
    })
  }

  Home() {
    this.post = {};
    this.spinner.show();
    this.pagination = [];
    this.postService.GetPost().subscribe((data:any)=>{
      this.postService.Pagination().subscribe((p:any)=>{
        var total = p[0].total/this.content;
        var pagination = parseInt(total.toString());
        for(var i = 0 ; i <= pagination; i++)
        {
          this.pagination.push(i+1);
        }
      },
      (error :any)=> {
        this.spinner.hide();
        console.log(error);
      })
      this.spinner.hide();
      this.posts = data.post;
    },
    (error :any)=> {
      this.spinner.hide();
      console.log(error);
    });
  }

  GetPostByPage(page) {
    this.page = page;
    this.Home();
  }


}
