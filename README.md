# Temporarily Deactivator

Laravel package to temporarily deactivate Eloquent models for a chosen amount of time.
Polymorphic storage, Blade modal, queued job to reactivate, and middleware to block access.

## Installation (local package)

1. Place package into `NemanjaIlic/model-deactivator`
2. In your main `composer.json`, add:
   ```json
   "repositories": [
     {
       "type": "path",
       "url": "NemanjaIlic/model-deactivator"
     }
   ]
