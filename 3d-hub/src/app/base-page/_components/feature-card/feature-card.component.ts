import { ChangeDetectionStrategy, Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-feature-card',
  templateUrl: './feature-card.component.html',
  styleUrls: ['./feature-card.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class FeatureCardComponent implements OnInit {
  @Input()
  name: string = '';
  @Input()
  link: string = '';
  @Input()
  thumnail: string = '';
  @Input()
  size: { width: number; height: number };

  @Input()
  maxHeight: number;

  cardWidth = 0;
  cardHeight = 0;

  captionHeight = 42;

  ngOnInit() {
    if (this.size && this.size.height) {
      this.cardHeight = this.maxHeight - this.captionHeight;
      this.cardWidth = (this.cardHeight / this.size.height) * this.size.width;
    }
  }
}
