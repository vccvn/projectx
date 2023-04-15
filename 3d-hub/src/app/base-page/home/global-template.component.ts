import { ChangeDetectionStrategy, ChangeDetectorRef, Component, OnInit } from '@angular/core';

import { Observable, Subject } from 'rxjs';
import { takeUntil } from 'rxjs/operators';

import { Store } from '@ngrx/store';

import * as fromApp from '@app/base-page/_store';
import { TemplateModel, TemplatesActions } from '@app/base-page/_store/template';

@Component({
  selector: 'app-global-template',
  templateUrl: './global-template.component.html',
  styleUrls: ['./global-template.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class HomeComponent implements OnInit {
  private unsubscribe$: Subject<void> = new Subject();

  templates$: Observable<Array<TemplateModel>>;
  templatesEnd$: Observable<boolean>;
  loading$: Observable<boolean>;

  categories = [
    { id: 1, text: 'Facebook Ads', value: false },
    { id: 2, text: 'Facebook Cover', value: false },
    { id: 3, text: 'Facebook Post', value: false },
    { id: 4, text: 'Youtube Cover', value: false },
    { id: 5, text: 'Tiktok Ads', value: false },
    { id: 6, text: 'Twitter Ads', value: false },
  ];

  items: Array<{ groupKey: number; key: number; num: number; model: Partial<TemplateModel> }> = [];

  limit = 3;
  page = 0;

  fulltext: string;
  collections = [
    {
      name: 'My Rencent Designs',
      link: '/design',
      items: [
        {
          id: 1,
          name: 'My design',
          thumbnail: 'https://cdn.crello.com/project-previews/573111ae-4122-4371-999d-1c5f273eac33.jpg?width=360',
          link: '',
          size: { width: 360, height: 180 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Post',
          thumbnail: 'https://cdn.crello.com/downloads/b3f443a2-2437-4bd3-bb44-abf45596efc6_350.jpeg',
          link: '',
          size: { width: 350, height: 350 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
      ],
    },
    {
      name: 'Featured Templates',
      link: '/design',
      items: [
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/03474cd1-c265-4018-8603-581e212519b5_350.jpeg',
          link: '',
          size: { width: 350, height: 293 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/201a64f5-d918-4e15-a39d-ece9a08c02d1_350.jpeg',
          link: '',
          size: { width: 247, height: 350 },
        },
      ],
    },
  ];

  templates = [
    {
      name: 'Facebook Ads',
      link: '/design',
      items: [
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 302 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/897f9f05-ff32-4789-a24e-5a5f886beccf_360.jpeg',
          link: '',
          size: { width: 360, height: 302 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/64b79a5e-d23f-4930-b067-61c00f7a9bd1_360.jpeg',
          link: '',
          size: { width: 360, height: 302 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/downloads/1feb06a3-8420-459a-a943-2780a5a892e2_360.jpeg',
          link: '',
          size: { width: 360, height: 302 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 360 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 360 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 360 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 360 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 360 },
        },
        {
          id: 2,
          name: 'Facebook Ads',
          thumbnail: 'https://cdn.crello.com/project-previews/c0ab7f0b-f0ed-4816-9e4f-585f9056ed9c.jpg?width=360',
          link: '',
          size: { width: 360, height: 360 },
        },
      ],
    },
    {
      name: 'Instraram Templates',
      link: '/design',
      items: [
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/f2cd562f-601a-4b44-97ef-48734e76758d_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/1033b88b-6b4c-4026-9c10-34092f8bab70_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/0848a32c-5195-441e-a2e1-0f072527d499_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/f2cd562f-601a-4b44-97ef-48734e76758d_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/1033b88b-6b4c-4026-9c10-34092f8bab70_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/0848a32c-5195-441e-a2e1-0f072527d499_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/1a9ee80e-fc18-4c11-96c2-6c5804a6175f_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/f2cd562f-601a-4b44-97ef-48734e76758d_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/f2cd562f-601a-4b44-97ef-48734e76758d_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/f2cd562f-601a-4b44-97ef-48734e76758d_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/1033b88b-6b4c-4026-9c10-34092f8bab70_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/0848a32c-5195-441e-a2e1-0f072527d499_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/1a9ee80e-fc18-4c11-96c2-6c5804a6175f_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/1033b88b-6b4c-4026-9c10-34092f8bab70_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
        {
          id: 1,
          name: 'Facebook Cover',
          thumbnail: 'https://cdn.crello.com/downloads/0848a32c-5195-441e-a2e1-0f072527d499_360.jpeg',
          link: '',
          size: { width: 203, height: 360 },
        },
      ],
    },
  ];

  constructor(private store$: Store<fromApp.PageState>, private cd: ChangeDetectorRef) {}

  ngOnInit(): void {
    this.loading$ = this.store$.select(fromApp.getTemplateGroupsLoading);
    this.templates$ = this.store$.select(fromApp.getTemplateGroups);
    this.templatesEnd$ = this.store$.select(fromApp.getTemplateGroupsEnd);
    this.templates$.pipe(takeUntil(this.unsubscribe$)).subscribe((res) => {});

    this.fetchData();
  }

  changeCategory(status: boolean, idx: number): void {
    if (idx === 0) {
      this.categories.forEach((i) => (i.value = status));
    } else {
      this.categories[idx].value = status;
    }
    // this.getData();
  }

  fetchData() {
    const params: {
      page?: number;
      limit?: number;
    } = {
      page: this.page,
      limit: this.limit,
    };

    this.store$.dispatch(TemplatesActions.getTemplateGroups({ payload: params }));
  }
}
