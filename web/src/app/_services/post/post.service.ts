import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '../../../../node_modules/@angular/common/http';
import { Observable } from '../../../../node_modules/rxjs';
import { environment } from '../../../environments/environment';
const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};
@Injectable({
  providedIn: 'root'
})
export class PostService {
  private apiUrl = environment.apiUrl;
  //private apiUrl = 'http://localhost:8080/server/post.php';
  constructor(private http: HttpClient) { }
  // ResponseData get the response from api
  ResponseData(body): any {
    return this.http.post<any[]>(this.apiUrl, body, httpOptions);
  }
  ToSeoUrl(url) {
    return url.toString()               // Convert to string
      .normalize('NFD')               // Change diacritics
      .replace(/[\u0300-\u036f]/g, '') // Remove illegal characters
      .replace(/\s+/g, '-')            // Change whitespace to dashes
      .toLowerCase()                  // Change to lowercase
      .replace(/&/g, '-and-')          // Replace ampersand
      .replace(/[^a-z0-9\-]/g, '')     // Remove anything that is not a letter, number or dash
      .replace(/-+/g, '-')             // Remove duplicate dashes
      .replace(/^-*/, '')              // Remove starting dashes
      .replace(/-*$/, '');             // Remove trailing dashes
  }
  GetPost(): Observable<any[]> {
    var reqdata = {
      'action': 'GetPostAdmin'
    };
    return this.ResponseData(JSON.stringify(reqdata));
  }
  ActivatePost(id, activate): Observable<any[]> {
    var reqdata = {
      'action': 'ActivatePost',
      'activate': activate,
      'id': id
    };
    return this.ResponseData(JSON.stringify(reqdata));
  }

  GetPostByUrl(url): Observable<any[]> {
    var reqdata = {
      'action': 'GetPostByUrl',
      'url': url,
    };
    return this.ResponseData(JSON.stringify(reqdata));
  }

  AddPost(fileToUpload: File, data) {
    debugger;
    const form_data: FormData = new FormData();
    if (fileToUpload != null) {
      var file_data = fileToUpload;
      var fileSplit = file_data.name.split(".");
      var filename = file_data.name;
      var fileLength = fileSplit.length;
      var extension = fileSplit[fileLength - 1];
      filename = this.ToSeoUrl(filename);
      filename = filename.replace(extension, "-");
      form_data.append('file', file_data);
      form_data.append('filename', filename);
      form_data.append('extension', extension);
    }
    else {
      form_data.append('filename', data.fileName );
    }

    var url = this.ToSeoUrl(data.title);
    form_data.append('id', data.id);
    form_data.append('action', 'InsertPost');
    form_data.append('title', data.title);
    form_data.append('description', data.description);
    form_data.append('video', data.video);
    form_data.append('mypost', data.mypost);
    form_data.append('url', url);
    form_data.append('catid', data.category);
    form_data.append('postcatid', data.postcatid);
    return this.http.post<any[]>(this.apiUrl, form_data);

  }

  Pagination(): Observable<any[]> {
    var reqdata = {
      'action': 'PostPagination',
    };
    return this.ResponseData(JSON.stringify(reqdata));
  }

  DeletePost(id) {
    var reqdata = {
      'action': 'DeletePost',
      'id': id,
    };
    return this.ResponseData(JSON.stringify(reqdata));
  }

  AddCategory(fileToUpload: File, data) {
    debugger;
    const form_data: FormData = new FormData();
    if (fileToUpload != null) {
      var file_data = fileToUpload;
      var fileSplit = file_data.name.split(".");
      var filename = file_data.name;
      var fileLength = fileSplit.length;
      var extension = fileSplit[fileLength - 1];
      filename = this.ToSeoUrl(filename);
      filename = filename.replace(extension, "-");
      form_data.append('file', file_data);
      form_data.append('filename', filename);
      form_data.append('extension', extension);
    }

  //  var url = this.ToSeoUrl(data.title);
    form_data.append('id', data.id);
    form_data.append('action', 'InsertCategory');
    form_data.append('title', data.title);
   // form_data.append('description', data.description);
  //  form_data.append('video', data.video);
  //  form_data.append('mypost', data.mypost);
 //  form_data.append('url', url);
    return this.http.post<any[]>(this.apiUrl, form_data);

  }

  GetCategory(): Observable<any[]> {
    var reqdata = {
      'action': 'GetCategory'
    };
    return this.ResponseData(JSON.stringify(reqdata));
  }





}