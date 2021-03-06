<?php

namespace Rowles\Console\Commands;

use Rowles\Console\OutputFormatter;
use Illuminate\Console\Command;
use Rowles\Console\OutputHandler;
use Rowles\Console\Processors\PreviewProcessor;

class GeneratePreviewCommand extends Command
{
    /** @var string  */
    protected string $identifier = 'previews';

    /**
     * The name and signature of the console command.
     *
     * @var mixed
     */
    protected $signature = 'generate-preview {name?}
        {--bulk-mode : Generate previews in bulk mode}
        {--start= : Starting point for preview (default: 10)}
        {--seconds= : Number of seconds to capture for preview (default: 10)}';

    /**
     * The console command description.
     *
     * @var mixed
     */
    protected $description = 'This command generates 10-second previews for videos.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $console = new OutputFormatter($this->output);
        $processor = new PreviewProcessor($this->output);

        if ($this->option('start')) {
            $processor->setStart($this->option('start'));
        }

        if ($this->option('seconds')) {
            $processor->setSeconds($this->option('seconds'));
        }

        $process = $processor->preview(
            $this->argument('name'),
            $this->option('bulk-mode')
        );

        OutputHandler::handle($process, $this->output, $this->identifier);
    }
}
