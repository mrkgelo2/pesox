
export class Graph {
    constructor() {
        this.canvas = document.getElementById("graph");

      
       
        this.canvas.width = this.canvas.clientWidth;
        this.canvas.height = this.canvas.clientHeight;

        this.rect = this.canvas.getBoundingClientRect();

        this.ctx = this.canvas.getContext("2d");

     
        this.padding = 50;
        this.stepX = 0;

    
        this.labels = null;
        this.data = null;
        this.currency = null;

        // Limit of labels to show
        this.labelCount = 10;

  
        this.showExtraData = false;


        window.onresize = () => {
            if (this.data != null && this.labels != null) {
                this.canvas.width = this.canvas.clientWidth;
                this.canvas.height = this.canvas.clientHeight;

                if (this.canvas.width < 550) {
                    this.labelCount = 3;
                } else {
                    this.labelCount = 6;
                }

                this.rect = this.canvas.getBoundingClientRect();
            
                this.drawClient(this.data, this.labels, this.currency);
            }
        };

        // mouse event
        this.canvas.addEventListener("mouseenter", () => {
            this.showExtraData = true;
        });

        // mouse leave event
        this.canvas.addEventListener("mouseleave", () => {
            this.showExtraData = false
            this.drawClient(this.data, this.labels, this.currency);
        });

        this.canvas.addEventListener("mousemove", (e) => this.showData(e));
    }

    //shows data when mouse hovers
    showData(e) {
        if (this.showExtraData) {
            let x = e.clientX - this.padding - this.rect.left;
            let y = this.canvas.height - this.padding;

            let dataIndex = Math.round(x / this.stepX);

            if (dataIndex >= 0 && dataIndex < this.data.length) {
                this.drawClient(this.data, this.labels, this.currency);

                let x = dataIndex * this.stepX + this.padding;

                this.drawLine(x, this.padding, x, y, "black");
                this.drawText(
                    x,
                    0,
                    100,
                    50,
                    `${this.data[dataIndex]} ${this.currency}`,
                    new Date(this.labels[dataIndex]).toUTCString(),
                    "white"
                );
            }
        }
    }

    drawText(x, y, width, height, text, dateText, color) {
        let metrics = this.ctx.measureText(dateText);

        if (metrics.width + x >= this.canvas.width) {
            x = this.canvas.width - metrics.width;
        }

        this.ctx.fillStyle = "black";
        this.ctx.fillText(text, x, height - 30);
        this.ctx.fillText(dateText, x, height - 10);
    }

    drawLine(x1, y1, x2, y2, color) {
        this.ctx.beginPath();

        this.ctx.moveTo(x1, y1);
        this.ctx.lineTo(x2, y2);

        this.ctx.strokeStyle = color;
        this.ctx.stroke();
    }

    fillRect(rect, color) {
        this.ctx.fillStyle = color;
        this.ctx.fillRect(rect.x, rect.y, rect.w, rect.h);
    }

    drawClient(data, labels, currency) {
        // Saving given values
        this.data = data;
        this.labels = labels;
        this.currency = currency;

        // Drawing background
        this.fillRect(
            { x: 0, y: 0, w: this.canvas.width, h: this.canvas.height },
            "white"
        );

        // Apply padding to all values
        let startX = this.padding;
        let startY = this.padding;
        let graphWidth = this.canvas.width - this.padding * 2;
        let graphHeight = this.canvas.height - this.padding * 2;

        // Find grid increment values
        this.stepX = Math.round(graphWidth / (labels.length - 1));
        let stepY = graphHeight / 4;

        if (this.stepX < 1) {
            this.stepX = 1;
        }

        let maxY = Math.max(...this.data);
        let minY = Math.min(...this.data);
        
        let diff = maxY - minY;

        // Decreasing max value and treating
        // min value as 0 (for rendering purposes)
        maxY -= minY;

        // Drawing graph backgroud
        this.fillRect(
            { x: startX, y: startY, w: graphWidth, h: graphHeight },
            "white"
        );

        this.drawGrid(
            startX,
            startY,
            graphWidth,
            graphHeight,
            this.stepX,
            stepY,
            labels.length - 1
        );

        this.drawLabels(
            labels,
            startX,
            this.stepX,
            stepY,
            minY,
            diff,
            graphHeight
        );

        this.drawGraph(
            data,
            startX,
            startY,
            maxY,
            minY,
            labels.length,
            this.stepX,
            graphHeight
        );
    }

    drawLabels(
        labels,
        startX,
        stepX,
        stepY,
        minY,
        diff,
        graphHeight,
        color = "black"
    ) {
        this.ctx.fillStyle = color;
        this.ctx.font = "12px Inter";

        // Calculating nth value to find which label to render
        // from the whole list of labels
        let step = Math.round(labels.length / this.labelCount);

        let metrics;
        let x = startX;

        for (let i = 0; i < labels.length; i++) {
            if ((i !== 0 && i % step == 0) || i == 0) {
                metrics = this.ctx.measureText(labels[i]);
                this.ctx.fillText(
                    labels[i],
                    startX - metrics.width / 2,
                    this.canvas.height
                );
            }

            startX += stepX;
        }

        let startY = this.padding + graphHeight;
        let offset = 0;

        for (let i = 0; i < 5; i++) {
            this.ctx.fillText((minY + offset).toFixed(4), 0, startY + 6);

            offset = ((i + 2) * diff) / 5;

            startY -= stepY;
        }
    }

    drawGrid(x, y, width, height, stepX, stepY, count, color = "#b8c8cf") {
        this.ctx.beginPath();

        let startY = this.padding;

        for (let i = 0; i < 5; i++) {
            this.ctx.moveTo(x, startY);
            this.ctx.lineTo(width + this.padding * 2, startY);

            startY += stepY;
        }

        this.ctx.strokeStyle = color;
        this.ctx.stroke();
    }

    drawGraph(
        data,
        startX,
        startY,
        maxY,
        minY,
        count,
        stepX,
        height,
        color = "blue"
    ) {
        this.ctx.beginPath();

        for (let i = 1; i < count; i++) {
            let y1 =
                height -
                Math.round(((this.data[i - 1] - minY) * height) / maxY) +
                this.padding;
            let y2 =
                height -
                Math.round(((this.data[i] - minY) * height) / maxY) +
                this.padding;

            this.ctx.moveTo(startX, y1);
            this.ctx.lineTo(startX + stepX, y2);

            startX += stepX;
        }

        this.ctx.strokeStyle = color;
        this.ctx.stroke();
    }
}