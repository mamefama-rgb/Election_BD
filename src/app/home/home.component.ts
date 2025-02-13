import { Component } from '@angular/core';

@Component({
  selector: 'app-home',
  imports: [],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {
  images = [
    { url: 'assets/dge.jpeg', description: 'Image 1' },
    { url: 'assets/images/image2.jpg', description: 'Image 2' },
    // Ajoutez d'autres images ici
  ];
}