import { Observable } from 'rxjs';
import { HttpEvent } from '@angular/common/http';
import { Marca } from '../models/marca.model';

export declare interface Crud {

    getAll(): Observable<HttpEvent<Marca>>;
    getById(): Observable<HttpEvent<Marca>>;
    create(): Observable<HttpEvent<Marca>>;
    update(): Observable<HttpEvent<Marca>>;

}


