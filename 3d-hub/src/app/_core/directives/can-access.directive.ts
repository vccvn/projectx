import { Directive, Input, OnDestroy, OnInit, TemplateRef, ViewContainerRef } from '@angular/core';
import { PermissionsService } from '../services/permissions.service';
import { Subscription } from 'rxjs';

@Directive({
  selector: '[appCanAccess]',
})
export class CanAccessDirective implements OnInit, OnDestroy {
  @Input() set appCanAccess(value: string | string[]) {
    this.applyPermission(value);
  }
  private permission$: Subscription;

  constructor(private templateRef: TemplateRef<any>, private viewContainer: ViewContainerRef, private workflowEvents: PermissionsService) {}

  ngOnInit(): void {}

  private applyPermission(value: string | string[]): void {
    this.permission$ = this.workflowEvents.checkAuthorization(value).subscribe((authorized) => {
      if (authorized) {
        this.viewContainer.createEmbeddedView(this.templateRef);
      } else {
        this.viewContainer.clear();
      }
    });
  }

  ngOnDestroy(): void {
    this.permission$.unsubscribe();
  }
}
