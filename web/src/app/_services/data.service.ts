import { Injectable } from '@angular/core';
import { BehaviorSubject } from '../../../node_modules/rxjs/internal/BehaviorSubject';

@Injectable({
  providedIn: 'root'
})
export class DataService {

  constructor() { }
 private DeleteSource = new BehaviorSubject<any>(0);
 deleteData = this.DeleteSource.asObservable();
 DeleteData(id : any){
  this.DeleteSource.next(id);
}
}
