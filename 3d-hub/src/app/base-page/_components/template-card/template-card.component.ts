import { ChangeDetectionStrategy, Component, Input } from '@angular/core';

@Component({
  selector: 'app-template-card',
  templateUrl: './template-card.component.html',
  styleUrls: ['./template-card.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class TemplateCardComponent {
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

  captionHeight = 0;

  ngOnInit() {
    if (this.size && this.size.height) {
      this.cardHeight = this.maxHeight - this.captionHeight;
      this.cardWidth = (this.cardHeight / this.size.height) * this.size.width;
    }
  }
}
