import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-pricing',
  templateUrl: './pricing.component.html',
  styleUrls: ['./pricing.component.scss'],
})
export class PricingComponent implements OnInit {
  i = {
    prices: [
      {
        id: 1,
        title: 'Basic',
        icon: 'shop',
        mo: 12,
        yr: 12 * 12,
        user: 0,
        project: 5,
        space: '2GB',
      },
      {
        id: 2,
        title: 'Company',
        icon: 'bank',
        mo: 25,
        yr: 25 * 12,
        user: 30,
        project: 150,
        space: '100GB',
      },
      {
        id: 3,
        title: 'Enterprise',
        icon: 'crown',
        mo: 50,
        yr: 50 * 12,
        user: -1,
        project: -1,
        space: '100GB',
      },
      {
        id: 4,
        title: 'Agency',
        icon: 'crown',
        mo: 50,
        yr: 50 * 12,
        user: -1,
        project: -1,
        space: '100GB',
      },
    ],
    faq: [
      {
        q: 'Can I cancel at anytime?',
        a:
          // tslint:disable-next-line:max-line-length
          'Yes, you can cancel anytime no questions are asked while you cancel but we would highly appreciate if you will give us some feedback.',
      },
      {
        q: 'My team has credits. How do we use them?',
        a: 'Once your team signs up for a subscription plan. enim eiusmod high life accusamus eoset dignissimos.',
      },
      {
        q: `How does Front's pricing work?`,
        a: 'Our subscriptions are tiered. based on the number of people enim eiusmod high life accusamus terry richardson ad squid.',
      },
      {
        q: 'How secure is Front?',
        a: 'Protecting the data you trust to Front is our first priority. at vero eoset dignissimos ducimus qui blanditiis.',
      },
      {
        q: 'Do you offer discounts?',
        a: `We've built in discounts at each tier for teams. leggings occaecat craft beer farm-to-table. raw denim aesthetic synth nesciunt.`,
      },
      {
        q: 'What is your refund policy?',
        a: 'We do not offer refunds apart leggings occaecat craft beer farm-to-table. raw leggings occaecat craft.',
      },
    ],
  };
  _type = false;
  type = 'mo';

  constructor() {}

  ngOnInit(): void {}

  typeChange(res: boolean): void {
    this.type = res ? 'yr' : 'mo';
  }
}
