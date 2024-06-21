## Queuing Application

Every Q4 of the current year and Q1 of the next, there is a surge of clients in the City Treasury Office of Laoag City. Most of these are taxpayers paying their annual tax and clients paying for renewal fees. Manual queuing by assigning a personnel to manage the numbered queue cards of clients are inefficient and error prone. To address these issues, Queuing Application automated the managing of different queue types to every employee processing payments. Proudly developed using Laravel and Vue.js

**Features:**

1.  Real-time queue number updates. A cashier presses the next button, then a notification sound plays in the computer outputting the Queue Display, and a the current queuing status is updated real-time.
    
2.  All cashiers are classified into a Queue Category that identifies the specific service he performs. They have a designated window number and a picture for easy identification of clients.
    
3.  Every category has an assigned queue card color for a regular client queue card and another color for a PWD client queue card. This color coding scheme helps a client identify which queue category he is in and what type of client he is.
    
4.  Queue number limit. Since it is impractical to manage several hundreds of queue cards, every queue category has its own queue number limit. When a queue category reaches this limit, the next queue number would go back to number 1, restarting the order again.
    
5.  Records the client count of every queue category at the press of the next button. This is so that the management would see the statistics of every category.
