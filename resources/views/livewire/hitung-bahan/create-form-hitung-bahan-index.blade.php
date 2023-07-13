@push('styles')
<style>
    .canvas-container {
      border: 1px solid #000;
      /* margin-bottom: 20px; */
    }
  </style>
@endpush
<div>
    {{-- Do your work, then step back. --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Layout Setting</h3>
                    <div class="card-options">
                        <div class="btn-list">
                            <button type="button" class="btn btn-sm btn-success" wire:click="addFormField"><i class="fe fe-plus"></i> Add Form Layout Setting</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="text-wrap">
                                <div class="example">
                                    <h3 class="card-title">Shape</h3>
                                    <div class="btn-list">
                                        <button type="button" class="btn btn-sm btn-dark" onclick="addRectangle(0)">Rectangle</button>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="addText(0)">Text</button>
                                        <button type="button" class="btn btn-sm btn-info" onclick="addLine(0)">Line</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-wrap">
                                <div class="example">
                                    <h3 class="card-title">Action</h3>
                                    <div class="btn-list">
                                        <button type="button" class="btn btn-sm btn-dark" onclick="copy(0)">Copy</button>
                                        <button type="button" class="btn btn-sm btn-info" onclick="paste(0)">Paste</button>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="deleteObjects(0)">Delete</button>
                                        <button type="button" class="btn btn-sm btn-success" onclick="exportCanvas(0)">Export</button>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="addCanvas(0)">Create Canvas</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="canvas-wrapper-0"></div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->

    
    @foreach($formFields as $index => $field)
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Layout Setting</h3>
                        <div class="card-options">
                            <div class="btn-list">
                                <button type="button" class="btn btn-sm btn-danger" wire:click="removeFormField({{ $index }})"><i class="fe fe-minus"></i> Delete Form Layout Setting</button>
                                <button type="button" class="btn btn-sm btn-success" wire:click="addFormField"><i class="fe fe-plus"></i> Add Form Layout Setting</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-wrap">
                                    <div class="example">
                                        <h3 class="card-title">Shape</h3>
                                        <div class="btn-list">
                                            <button type="button" class="btn btn-sm btn-dark" onclick="addRectangle({{ $field }})">Rectangle</button>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addText({{ $field }})">Text</button>
                                            <button type="button" class="btn btn-sm btn-info" onclick="addLine({{ $field }})">Line</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-wrap">
                                    <div class="example">
                                        <h3 class="card-title">Action</h3>
                                        <div class="btn-list">
                                            <button type="button" class="btn btn-sm btn-dark" onclick="copy({{ $field }})">Copy</button>
                                            <button type="button" class="btn btn-sm btn-info" onclick="paste({{ $field }})">Paste</button>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="deleteObjects({{ $field }})">Delete</button>
                                            <button type="button" class="btn btn-sm btn-success" onclick="exportCanvas({{ $field }})">Export</button>
                                            <button type="button" class="btn btn-sm btn-warning" onclick="createCanvas({{ $field }})">Create Canvas</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="canvas-wrapper-{{ $field }}"></div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 END -->
    @endforeach
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
<script src="https://rawgit.com/fabricjs/fabric.js/master/lib/centering_guidelines.js"></script>
<script src="https://rawgit.com/fabricjs/fabric.js/master/lib/aligning_guidelines.js"></script>
{{-- <script>
  var canvasId = 0;
  var canvases = {};

  function addCanvas(canvasId) {
    var canvasContainer = document.createElement('div');
    canvasContainer.id = 'canvas-container-' + (++canvasId);
    canvasContainer.classList.add('canvas-container');

    var canvasWrapper = document.getElementById('canvas-wrapper-' + canvasId);
    canvasWrapper.appendChild(canvasContainer);

    var canvasElement = document.createElement('canvas');
    canvasElement.id = 'canvas-' + canvasId;
    canvasContainer.appendChild(canvasElement);

    var newCanvas = new fabric.Canvas(canvasElement.id);
    canvases[canvasContainer.id] = newCanvas;
  }

  function addRectangle(canvasId) {
    var currentCanvas = getCurrentCanvas(canvasId);
    var rect = new fabric.Rect({
      left: 50,
      top: 50,
      width: 100,
      height: 100,
      fill: 'red'
    });
    currentCanvas.add(rect);
  }

  function addText(canvasId) {
    var currentCanvas = getCurrentCanvas(canvasId);
    var text = new fabric.Textbox('Sample Text', {
      left: 50,
      top: 50,
      width: 200,
      fontSize: 20,
      fontFamily: 'Arial',
      fill: 'black'
    });
    currentCanvas.add(text);
  }

  function addLine(canvasId) {
    var currentCanvas = getCurrentCanvas(canvasId);
    var line = new fabric.Line([50, 50, 200, 200], {
      fill: 'black',
      stroke: 'black',
      strokeWidth: 2
    });
    currentCanvas.add(line);
  }

  function copy(canvasId) {
    var currentCanvas = getCurrentCanvas(canvasId);
    var activeObject = currentCanvas.getActiveObject();
    if (activeObject) {
      activeObject.clone(function(cloned) {
        currentCanvas.clipboard = cloned;
      });
    }
  }

  function paste(canvasId) {
    var currentCanvas = getCurrentCanvas(canvasId);
    if (currentCanvas.clipboard) {
      currentCanvas.clipboard.clone(function(clonedObj) {
        currentCanvas.discardActiveObject();
        clonedObj.set({
          left: clonedObj.left + 10,
          top: clonedObj.top + 10,
          evented: true,
        });
        if (clonedObj.type === 'activeSelection') {
          clonedObj.canvas = currentCanvas;
          clonedObj.forEachObject(function(obj) {
            currentCanvas.add(obj);
          });
          clonedObj.setCoords();
        } else {
          currentCanvas.add(clonedObj);
        }
        currentCanvas.clipboard.top += 10;
        currentCanvas.clipboard.left += 10;
        currentCanvas.setActiveObject(clonedObj);
        currentCanvas.requestRenderAll();
      });
    }
  }

  function deleteObjects(canvasId) {
    var currentCanvas = getCurrentCanvas(canvasId);
    var activeObject = currentCanvas.getActiveObject();
    if (activeObject) {
      if (activeObject.type === 'activeSelection') {
        activeObject.forEachObject(function(obj) {
          currentCanvas.remove(obj);
        });
      } else {
        currentCanvas.remove(activeObject);
      }
      currentCanvas.discardActiveObject();
      currentCanvas.requestRenderAll();
    }
  }

  function exportCanvas(canvasId) {
    var currentCanvas = getCurrentCanvas(canvasId);
    var dataURL = currentCanvas.toDataURL();
    // Kirim dataURL ke server melalui AJAX
    // ...
  }

  function getCurrentCanvas(canvasId) {
    var currentCanvasId = 'canvas-container-' + canvasId;
    return canvases[currentCanvasId];
  }

</script> --}}

<script>
    //   var canvasId = 0;
      var canvases = {};
    
    function addCanvas(index) {
        var canvasContainer = document.createElement('div');
        canvasContainer.id = 'canvas-container-' + index;
        canvasContainer.classList.add('canvas-container');

        var canvasWrapper = document.getElementById('canvas-wrapper-' + index);
        canvasWrapper.appendChild(canvasContainer);

        // Buat elemen <canvas> baru
        var canvasElement = document.createElement('canvas');
        canvasElement.id = 'canvas-' + index;
        canvasElement.width = canvasWrapper.offsetWidth; // Atur lebar sesuai dengan lebar canvas-wrapper
        canvasElement.height = canvasWrapper.offsetWidth / 1.5; // Atur tinggi sesuai kebutuhan

        // Tambahkan elemen <canvas> ke dalam wrapper
        // canvasWrapper.appendChild(canvasElement);
        canvasContainer.appendChild(canvasElement);

        // Inisialisasi objek canvas menggunakan Fabric.js
        var canvas = new fabric.Canvas('canvas-' + index, {
            snapAngle: 45,
            guidelines: true,
            snapToGrid: 10,
            snapToObjects: true
        });

        // Tambahkan kode logika lainnya di sini, seperti menambahkan objek atau event listener

        console.log('Canvas created:', canvas);
        canvases[canvasContainer.id] = canvas;
        initCenteringGuidelines(canvas);
        initAligningGuidelines(canvas);
    }
    
    function addRectangle(index) {
        var currentCanvas = getCurrentCanvas(index);
        var rect = new fabric.Rect({
          left: 50,
          top: 50,
          width: 100,
          height: 100,
          fill: 'transparent',
          stroke: 'black',
          strokeWidth: 2,
          snapAngle: 15,
          snapThreshold: 10,
          snapToGrid: 10,
          strokeUniform: true
        });
        currentCanvas.add(rect);
    }
    
      function addText(index) {
        var currentCanvas = getCurrentCanvas(index);
        var text = new fabric.Textbox('Sample Text', {
          left: 50,
          top: 50,
          width: 200,
          fontSize: 20,
          fontFamily: 'Arial',
          fill: 'black',
          snapAngle: 15,
          snapThreshold: 10,
          snapToGrid: 10,
          strokeUniform: true
        });
        currentCanvas.add(text);
      }
    
      function addLine(index) {
        var currentCanvas = getCurrentCanvas(index);
        var line = new fabric.Line([50, 50, 200, 200], {
          fill: 'black',
          stroke: 'black',
          strokeWidth: 2,
          snapAngle: 15,
          snapThreshold: 10,
          snapToGrid: 10,
          strokeUniform: true
        });
        currentCanvas.add(line);
      }
    
      function copy(index) {
        var currentCanvas = getCurrentCanvas(index);
        var activeObject = currentCanvas.getActiveObject();
        if (activeObject) {
          activeObject.clone(function(cloned) {
            currentCanvas.clipboard = cloned;
          });
        }
      }
    
      function paste(index) {
        var currentCanvas = getCurrentCanvas(index);
        if (currentCanvas.clipboard) {
          currentCanvas.clipboard.clone(function(clonedObj) {
            currentCanvas.discardActiveObject();
            clonedObj.set({
              left: clonedObj.left + 10,
              top: clonedObj.top + 10,
              evented: true,
            });
            if (clonedObj.type === 'activeSelection') {
              clonedObj.canvas = currentCanvas;
              clonedObj.forEachObject(function(obj) {
                currentCanvas.add(obj);
              });
              clonedObj.setCoords();
            } else {
              currentCanvas.add(clonedObj);
            }
            currentCanvas.clipboard.top += 100;
            currentCanvas.clipboard.left += 100;
            currentCanvas.setActiveObject(clonedObj);
            currentCanvas.requestRenderAll();
          });
        }
      }
    
      function deleteObjects(index) {
        var currentCanvas = getCurrentCanvas(index);
        var activeObject = currentCanvas.getActiveObject();
        if (activeObject) {
          if (activeObject.type === 'activeSelection') {
            activeObject.forEachObject(function(obj) {
              currentCanvas.remove(obj);
            });
          } else {
            currentCanvas.remove(activeObject);
          }
          currentCanvas.discardActiveObject();
          currentCanvas.requestRenderAll();
        }
      }
    
      function exportCanvas(index) {
        var currentCanvas = getCurrentCanvas(index);
        var dataURL = currentCanvas.toDataURL();
        // Kirim dataURL ke server melalui AJAX
        // ...
      }
    
      function getCurrentCanvas(index) {
        var currentCanvasId = 'canvas-container-' + index;
        return canvases[currentCanvasId];
      }


    </script>
@endpush
