import { Component, OnInit, ElementRef, ViewChild, Input } from '@angular/core';
import { DataService } from '../../_services/data.service';

@Component({
  selector: 'app-delete',
  templateUrl: './delete.component.html',
  styleUrls: ['./delete.component.css']
})
export class DeleteComponent implements OnInit {
  @ViewChild('btnClose') btnClose : ElementRef 
  @Input()  postId : any;
  constructor(private dataservice : DataService) { }

  ngOnInit() {
  }
  Delete(){
    debugger;
    this.dataservice.DeleteData(this.postId);
    this.btnClose.nativeElement.click();
  }
}
