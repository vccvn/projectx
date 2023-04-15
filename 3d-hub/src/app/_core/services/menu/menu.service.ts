import { Injectable, OnDestroy } from '@angular/core';
import { Observable, BehaviorSubject } from 'rxjs';
import { share } from 'rxjs/operators';
import { Menu, menuData } from './menu.model';
@Injectable({
  providedIn: 'root',
})
export class MenuService implements OnDestroy {
  private items: any[] = menuData;
  change$: BehaviorSubject<Menu[]> = new BehaviorSubject<Menu[]>([]);
  constructor() {}

  add(items: Menu[]) {
    this.items = items;
    this.resume();
  }

  get menus() {
    return this.items;
  }

  resume() {
    this.change$.next(this.items);
  }

  get change(): Observable<Menu[]> {
    return this.change$.pipe(share());
  }

  ngOnDestroy(): void {
    this.change$.unsubscribe();
  }
}
